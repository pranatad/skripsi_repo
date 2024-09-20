from flask import Flask, request, jsonify, redirect
import cv2 as cv
import numpy as np
import pytesseract as tsr
import mysql.connector

app = Flask(__name__)

# Set the path to the Tesseract executable
tsr.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

# Function to preprocess and extract digits using Tesseract OCR
def extract_digits(image):
    # Menentukan ROI (Region of Interest) dalam bentuk kotak pembatas (x, y, w, h)
    roi = (246, 93, 450, 145)  # Adjusted ROI to cover the entire number region
    x, y, w, h = roi
    roi_image = image[y:y + h, x:x + w]

    # Proses gambar dan OCR
    gray = cv.cvtColor(roi_image, cv.COLOR_BGR2GRAY)
    thresh = cv.threshold(gray, 0, 255, cv.THRESH_BINARY_INV | cv.THRESH_OTSU)[1]

    # Find contours and filter based on size and aspect ratio
    cnts, _ = cv.findContours(thresh, cv.RETR_EXTERNAL, cv.CHAIN_APPROX_SIMPLE)
    digits = []
    for c in cnts:
        x, y, w, h = cv.boundingRect(c)
        # Filter contours based on size and aspect ratio
        if 30 < w < 80 and 60 < h < 120 and float(w) / h > 0.5:
            digits.append(c)

    if digits:
        # Find convex hull to cover all digits
        digits = np.vstack([digits[i] for i in range(len(digits))])
        hull = cv.convexHull(digits)
        # Create a mask for the digits
        mask = np.zeros(thresh.shape[:2], dtype='uint8')
        cv.drawContours(mask, [hull], -1, 255, -1)
        # Apply the mask to the image
        masked_image = cv.bitwise_and(thresh, thresh, mask=mask)
        # Perform OCR on the masked image
        config = "--psm 10 -c tessedit_char_whitelist=0123456789"
        text = tsr.image_to_string(masked_image, config=config)
        # Return the extracted digits
        return text.strip() if text else None

    return None

# Function to save prediction to MySQL database
def save_to_database(prediction):
    try:
        connection = mysql.connector.connect(
            host='127.0.0.1',
            database='pdam_new3',
            user='root',
            password=''
        )

        cursor = connection.cursor()
        sql_insert_query = """ INSERT INTO predictions (prediction) VALUES (%s)"""
        cursor.execute(sql_insert_query, (prediction,))
        connection.commit()

    except mysql.connector.Error as error:
        print("Failed to insert record into MySQL table {}".format(error))

    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

@app.route('/predict', methods=['POST'])
def predict():
    try:
        image = request.files['image']
        file_bytes = np.asarray(bytearray(image.read()), dtype=np.uint8)
        img = cv.imdecode(file_bytes, cv.IMREAD_COLOR)

        prediction = extract_digits(img)
        if prediction is not None:
            save_to_database(prediction)
            return redirect("http://tugutirta.my.id/prediction")
        else:
            return jsonify({"error": "No valid digits found"}), 400

    except Exception as e:
        return jsonify({"error": str(e)}), 400

if __name__ == '__main__':
    app.run(host='tugutirta.my.id', port=8000, debug=True)