from flask import Flask, request, jsonify, redirect, url_for
import tensorflow as tf
import numpy as np
import cv2 as cv
import imutils
import mysql.connector

app = Flask(__name__)

# Langkah 1: Memuat Model TFLite
interpreter = tf.lite.Interpreter(model_path="digit_model.tflite")
interpreter.allocate_tensors()

# Mendapatkan indeks input dan output
input_details = interpreter.get_input_details()
output_details = interpreter.get_output_details()

# Fungsi untuk mempersiapkan gambar
def preprocess_image(image):
    image = cv.resize(image, (28, 28))
    image = image / 255.0
    image = image.reshape(1, 28, 28, 1).astype(np.float32)
    return image

# Fungsi untuk melakukan inferensi
def predict_digit(image):
    interpreter.set_tensor(input_details[0]['index'], image)
    interpreter.invoke()
    output = interpreter.get_tensor(output_details[0]['index'])
    predicted_digit = np.argmax(output)
    return predicted_digit

# Fungsi untuk menyimpan prediksi ke dalam database
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

# Menambahkan route /predict
@app.route('/predict', methods=['POST'])
def predict():
    try:
        image = request.files['image']
        file_bytes = np.asarray(bytearray(image.read()), dtype=np.uint8)
        img = cv.imdecode(file_bytes, cv.IMREAD_COLOR)
        roi = (340, 320, 565, 170)  # (x, y, w, h)

        gray_image = cv.cvtColor(img, cv.COLOR_BGR2GRAY)
        x, y, w, h = roi
        roi_image = gray_image[y:y+h, x:x+w]

        thresh = cv.threshold(roi_image, 0, 255, cv.THRESH_BINARY_INV | cv.THRESH_OTSU)[1]
        dist = cv.distanceTransform(thresh, cv.DIST_L2, 5)

        if dist is not None:
            dist = cv.normalize(dist, dist, 0, 1.0, cv.NORM_MINMAX)
            dist = (dist * 255).astype('uint8')
            dist = cv.threshold(dist, 0, 255, cv.THRESH_BINARY | cv.THRESH_OTSU)[1]

            kernel = cv.getStructuringElement(cv.MORPH_CROSS, (6, 6))
            opening = cv.morphologyEx(dist, cv.MORPH_OPEN, kernel)

            kernel = cv.getStructuringElement(cv.MORPH_CROSS, (4, 4))
            dilation = cv.dilate(opening, kernel, iterations=2)

            cnts = cv.findContours(dilation.copy(), cv.RETR_EXTERNAL, cv.CHAIN_APPROX_SIMPLE)
            cnts = imutils.grab_contours(cnts)

            nums = []
            for c in cnts:
                (x, y, w, h) = cv.boundingRect(c)
                if w >= 15 and h > 50:
                    nums.append(c)
            nums = sorted(nums, key=lambda c: cv.boundingRect(c)[0])
            nums = np.vstack([nums[i] for i in range(0, len(nums))])
            hull = cv.convexHull(nums)

            mask = np.zeros(dilation.shape[:2], dtype='uint8')
            cv.drawContours(mask, [hull], -1, 255, -1)
            mask = cv.dilate(mask, None, iterations=2)

            final = cv.bitwise_and(dilation, dilation, mask=mask)

            contours = cv.findContours(final.copy(), cv.RETR_EXTERNAL, cv.CHAIN_APPROX_SIMPLE)
            contours = imutils.grab_contours(contours)

            segmented_digits = []
            for c in contours:
                (x, y, w, h) = cv.boundingRect(c)
                if w >= 15 and h > 50:
                    digit_image = final[y:y+h, x:x+w]
                    segmented_digits.append((x, digit_image))

            segmented_digits = sorted(segmented_digits, key=lambda x: x[0])

            predicted_digits = []
            for (x, digit_image) in segmented_digits:
                preprocessed_image = preprocess_image(digit_image)
                predicted_digit = predict_digit(preprocessed_image)
                predicted_digits.append(predicted_digit)

            final_prediction = ''.join(map(str, predicted_digits))
            save_to_database(final_prediction)

            # Mengarahkan ke URL tertentu setelah POST
            return redirect("http://tugutirta.my.id/prediction")

        else:
            return jsonify({"error": "Failed to process the image"}), 400

    except Exception as e:
        return jsonify({"error": str(e)}), 400

if __name__ == '__main__':
    app.run(host='tugutirta.my.id', port=8000, debug=True)
