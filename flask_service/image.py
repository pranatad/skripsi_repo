from flask import Flask, request, jsonify, redirect
import cv2 as cv
import numpy as np
import pytesseract as tsr
import mysql.connector
import base64

app = Flask(__name__)

# Set the path to the Tesseract executable

# Function to preprocess and extract digits using Tesseract OCR
def extract_digits(image):
    # Define ROI (Region of Interest) coordinates (x, y, w, h)
    roi = (200, 300, 1220, 700)
    x, y, w, h = roi
    roi_image = image[y:y + h, x:x + w]

    # Convert ROI to grayscale
    gray = cv.cvtColor(roi_image, cv.COLOR_BGR2GRAY)

    # Apply simple thresholding
    _, gray = cv.threshold(gray, 90, 255, cv.THRESH_BINARY)

    # Apply Gaussian Blur to reduce noise
    gray = cv.GaussianBlur(gray, (5, 5), 0)

    # Apply morphological closing with a smaller kernel
    kernel = cv.getStructuringElement(cv.MORPH_RECT, (2, 2))
    gray = cv.morphologyEx(gray, cv.MORPH_CLOSE, kernel, iterations=2)

    # Apply Median Blur to reduce noise
    gray = cv.medianBlur(gray, 5)

    # Invert the image (convert to negative)
    negative = cv.bitwise_not(gray)

    # Apply threshold to create binary image
    _, binary = cv.threshold(negative, 0, 255, cv.THRESH_BINARY + cv.THRESH_OTSU)

    # Apply morphological operations to clean noise
    kernel = cv.getStructuringElement(cv.MORPH_RECT, (2, 2))
    cleaned = cv.morphologyEx(binary, cv.MORPH_CLOSE, kernel)

    # Remove lines around the digits
    kernel_large = cv.getStructuringElement(cv.MORPH_RECT, (5, 5))
    cleaned = cv.morphologyEx(cleaned, cv.MORPH_OPEN, kernel_large)

    # Use Tesseract to recognize text
    custom_config = r'--oem 3 --psm 6 -c tessedit_char_whitelist=0123456789'
    text = tsr.image_to_string(cleaned, config=custom_config).strip()

    # Return the extracted digits
    return text if text else '0'

# Function to save prediction to MySQL database
def save_to_database(prediction, id_images=None):
    try:
        connection = mysql.connector.connect(
            host='127.0.0.1',
            database='pdam_new3',
            user='root',
            password=''
        )

        cursor = connection.cursor()
        sql_insert_query = """INSERT INTO predictions (prediction, id_images) VALUES (%s, %s)"""
        cursor.execute(sql_insert_query, (prediction, id_images))
        connection.commit()

    except mysql.connector.Error as error:
        print("Failed to insert record into MySQL table {}".format(error))
        raise  # Re-raise the exception to ensure Flask handles it properly

    finally:
        if connection and connection.is_connected():
            cursor.close()
            connection.close()

@app.route('/predict', methods=['POST'])
def predict():
    try:
        data = request.get_json()

        if 'image' not in data:
            return jsonify({"error": "No image provided"}), 400
        
        image_base64 = data['image']
        id_images = data.get('id_images')

        image_data = base64.b64decode(image_base64)
        np_arr = np.frombuffer(image_data, np.uint8)
        img = cv.imdecode(np_arr, cv.IMREAD_COLOR)

        prediction = extract_digits(img)
        save_to_database(prediction, id_images)
        return jsonify({'message': 'Image uploaded successfully', 'prediction': prediction}), 200

    except Exception as e:
        return jsonify({"error": str(e)}), 400

@app.route('/upload_image', methods=['POST'])
def upload_image():
    try:
        image = request.files['image']
        file_bytes = np.asarray(bytearray(image.read()), dtype=np.uint8)
        img = cv.imdecode(file_bytes, cv.IMREAD_COLOR)

        prediction = extract_digits(img)
        save_to_database(prediction)
        return redirect("http://192.168.43.200:9000/uploadgambar")

    except Exception as e:
        return jsonify({"error": str(e)}), 400

if __name__ == '__main__':
    app.run(host='192.168.43.200', port=8000, debug=True)
