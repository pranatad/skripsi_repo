<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CameraController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        // Retrieve the device_name from the request header
        $deviceName = $request->header('device_name');

        // Find the device ID by matching the device_name
        $device = DB::table('devices')->where('device_name', $deviceName)->first();

        if (!$device) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        $image = $request->input('image');

        // Save the base64 image to the database with the device ID
        $imageId = DB::table('images')->insertGetId([
            'image' => $image,
            'id_devices' => $device->id,
        ]);

        $url = 'http://192.168.43.200:8000/predict';

        // Send the image to the Flask API
        $response = Http::post($url, [
            'image' => $image,
            'id_images' => $imageId,
        ]);

        if ($response->successful()) {
            return response()->json(['message' => 'Image uploaded and processed successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to process the image'], 500);
        }
    }
    public function api(Request $request)
    {
        $primaryId = $request->input('id_device');

        $results = DB::table('devices')
            ->join('images', 'devices.id', '=', 'images.id_devices')
            ->join('predictions', 'images.id', '=', 'predictions.id_images')
            ->where('devices.id', $primaryId)
            ->select('predictions.prediction')
            ->orderBy('predictions.id', 'desc')
            ->first();

        $prediction = $results ? $results->prediction : '';

        return response($prediction);
    }

    public function index()
    {
        $images = DB::table('images')->get();
        return view('images.index', ['images' => $images]);
    }
}
