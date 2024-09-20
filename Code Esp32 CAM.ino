#include <WebServer.h>
#include <WiFi.h>
#include <esp32cam.h>
#include <base64.h>  // Include the base64 library
#include <HTTPClient.h>

// WiFi credentials
const char* WIFI_SSID = "Iphone XR";
const char* WIFI_PASS = "123444444";

// Web server
WebServer server(80);

// Camera resolutions
static auto loRes = esp32cam::Resolution::find(320, 240);
static auto midRes = esp32cam::Resolution::find(350, 530);
static auto hiRes = esp32cam::Resolution::find(1600, 1200);

// Define the flash pin
const int FLASH_PIN = 4;

// Device details
const char* device_name = "ESP32-CAM-13";
const char* mac_address = "E7:24:95:FA:13:6D"; // Replace with your MAC address

// Timing variables
unsigned long previousMillis = 0;
const long interval = 35000; // Interval to take a photo (milliseconds)

// Function to send device details to the server
void sendDeviceDetails() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    String serverUrl = "http://192.168.43.200:9000/api/devices";  // Replace with your Laravel endpoint

    http.begin(serverUrl.c_str());
    http.addHeader("Content-Type", "application/json");

    String jsonData = "{\"device_name\":\"" + String(device_name) + "\",\"mac_address\":\"" + String(mac_address) + "\"}";
    int httpResponseCode = http.POST(jsonData);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println(httpResponseCode);
      Serial.println(response);

      // Handle the response based on HTTP status code
      if (httpResponseCode == 201) {
        // Device added successfully
        Serial.println("Device added successfully!");
      } else if (httpResponseCode == 422) {
        // Device already exists
        Serial.println("Device already exists!");
      } else {
        Serial.println("Unknown response from server.");
      }
    } else {
      Serial.print("Error on sending POST: ");
      Serial.println(httpResponseCode);
    }

    http.end();
  } else {
    Serial.println("WiFi Disconnected");
  }
}

void serveJpgBase64()
{
  // Turn on the flash
  digitalWrite(FLASH_PIN, HIGH);
  delay(100);  // Small delay to ensure the flash is on before capturing

  auto frame = esp32cam::capture();

  // Turn off the flash
  digitalWrite(FLASH_PIN, LOW);

  if (frame == nullptr) {
    Serial.println("CAPTURE FAIL");
    server.send(503, "", "");
    return;
  }
  Serial.printf("CAPTURE OK %dx%d %db\n", frame->getWidth(), frame->getHeight(),
                static_cast<int>(frame->size()));

  // Convert the frame to Base64
  String base64Image = base64::encode((uint8_t*)frame->data(), frame->size());

  // Send the Base64 encoded image
  server.send(200, "text/plain", base64Image);
}

void handleJpgLoBase64()
{
  if (!esp32cam::Camera.changeResolution(loRes)) {
    Serial.println("SET-LO-RES FAIL");
  }
  serveJpgBase64();
}

void handleJpgHiBase64()
{
  if (!esp32cam::Camera.changeResolution(hiRes)) {
    Serial.println("SET-HI-RES FAIL");
  }
  serveJpgBase64();
}

void handleJpgMidBase64()
{
  if (!esp32cam::Camera.changeResolution(midRes)) {
    Serial.println("SET-MID-RES FAIL");
  }
  serveJpgBase64();
}

void sendPhotoToServer(String base64Image, const char* deviceName) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;

    http.begin("http://192.168.43.200:9000/api/upload-image"); // Replace with your Laravel endpoint
    http.addHeader("Content-Type", "application/json");
    http.addHeader("device_name", deviceName);  // Add device_name as a header

    String payload = "{\"image\":\"" + base64Image + "\"}";

    int httpResponseCode = http.POST(payload);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println(httpResponseCode);
      Serial.println(response);
    } else {
      Serial.print("Error on sending POST: ");
      Serial.println(httpResponseCode);
    }

    http.end();
  } else {
    Serial.println("WiFi Disconnected");
  }
}

void takeAndDisplayPhoto() {
  // Set the resolution to 800x600 before taking the photo
  if (!esp32cam::Camera.changeResolution(hiRes)) {
    Serial.println("SET-HI-RES FAIL");
    return;
  }

  // Turn on the flash
  digitalWrite(FLASH_PIN, HIGH);
  delay(100);  // Small delay to ensure the flash is on before capturing

  auto frame = esp32cam::capture();

  // Turn off the flash
  digitalWrite(FLASH_PIN, LOW);

  if (frame == nullptr) {
    Serial.println("CAPTURE FAIL");
    return;
  }

  Serial.printf("CAPTURE OK %dx%d %db\n", frame->getWidth(), frame->getHeight(),
                static_cast<int>(frame->size()));

  // Convert the frame to Base64
  String base64Image = base64::encode((uint8_t*)frame->data(), frame->size());

  // Display the Base64 encoded image in the serial monitor
  Serial.println(base64Image);

  // Send the Base64 encoded image to the server
  sendPhotoToServer(base64Image, device_name);
}

void setup() {
  Serial.begin(115200);
  Serial.println();
  {
    using namespace esp32cam;
    Config cfg;
    cfg.setPins(pins::AiThinker);
    cfg.setResolution(hiRes);  // Set initial resolution to 800x600
    cfg.setBufferCount(2);
    cfg.setJpeg(80);

    bool ok = Camera.begin(cfg);
    Serial.println(ok ? "CAMERA OK" : "CAMERA FAIL");
  }

  // Initialize the flash pin
  pinMode(FLASH_PIN, OUTPUT);
  digitalWrite(FLASH_PIN, LOW);  // Ensure the flash is off initially

  WiFi.persistent(false);
  WiFi.mode(WIFI_STA);
  WiFi.begin(WIFI_SSID, WIFI_PASS);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
  }
  Serial.print("http://");
  Serial.println(WiFi.localIP());
  Serial.println("  /cam-lo-base64");
  Serial.println("  /cam-hi-base64");
  Serial.println("  /cam-mid-base64");

  server.on("/cam-lo-base64", handleJpgLoBase64);
  server.on("/cam-hi-base64", handleJpgHiBase64);
  server.on("/cam-mid-base64", handleJpgMidBase64);

  server.begin();

  // Send device details to the server
  sendDeviceDetails();
}

void loop() {
  server.handleClient();

  unsigned long currentMillis = millis();
  if (currentMillis - previousMillis >= interval) {
    previousMillis = currentMillis;
    takeAndDisplayPhoto();
  }
}
