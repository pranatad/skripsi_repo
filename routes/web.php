<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\CameraController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Esp32CamController;
use App\Http\Controllers\DeviceController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/logout', 'LoginController@logout');
Route::get('/', 'LandingPageController@index');
Route::post('/login', 'LoginController@login');
Route::get('/login', 'LoginController@loginhome')->name('login');
// Route::get('/api', [CameraController::class, 'api']);
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/devices', [DeviceController::class, 'index']);
    // Route untuk menampilkan daftar devices
    Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');

    // Route untuk menyimpan device baru
    Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');

    // Route untuk menghapus device
    Route::delete('/devices/{id}', [DeviceController::class, 'destroy'])->name('devices.destroy');
    Route::get('/prediction', 'PredictionController@index')->name('prediction');
    Route::get('/uploadgambar', 'UploadController@index')->name('uploadgambar');
    Route::get('/grafik', 'GrafikController@index')->name('grafik');
    // routes/web.php
    Route::get('/get_predictions/{deviceId}}', 'UploadController@getPredictions');

    Route::get('/image', 'ImageController@index')->name('image');
    Route::get('/image', [ImageController::class, 'index'])->name('image');

    // Route untuk menghapus gambar
    Route::delete('/image/{id}', [ImageController::class, 'destroy'])->name('images.destroy');

    Route::get('/user', 'UserController@index');
    Route::get('/user/add', 'UserController@add');
    Route::get('/user/edit/{id}', 'UserController@edit');
    Route::get('/user/delete/{id}', 'UserController@delete');
    Route::post('/user/add', 'UserController@save')->name('user');
    Route::post('/user/edit/{id}', 'UserController@update')->name('edituser');

    Route::post('/upload-image', [ImageUploadController::class, 'upload']);
    Route::get('/images', [ImageController::class, 'index'])->name('images.index');
    Route::get('/images/data', [ImageController::class, 'getData'])->name('images.data');

    Route::post('/detect-digit', function (Request $request) {
        $imageBase64 = $request->input('image');
        $response = Http::post('http://192.168.43.200:8000/api/upload-image', [
            'image' => $imageBase64,
        ]);

        return $response->json();
    });
    Route::post('/detect-digit', function (Request $request) {
        $imageBase64 = $request->input('image');
        $response = Http::post('http://192.168.43.200:8000/api/upload-image', [
            'image' => $imageBase64,
        ]);

        return $response->json();
    });
});
