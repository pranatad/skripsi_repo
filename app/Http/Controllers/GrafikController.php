<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB facade untuk menggunakan query builder
use RealRashid\SweetAlert\Facades\Alert;
use ConsoleTVs\Charts\Facades\Charts;

class GrafikController extends Controller
{
    public function index()
    {
        $iddevices = DB::table('devices')->pluck('id')->toArray();
        $predictionsall = DB::table('devices')
            ->join('images', 'images.id_devices', '=', 'devices.id')
            ->join('predictions', 'predictions.id_images', '=', 'images.id')
            ->select('predictions.prediction', 'predictions.created_at', 'devices.id as device_id')
            ->get()
            ->toArray();

        $predictionsData = DB::table('predictions')
            ->select('prediction', 'created_at')
            ->get()
            ->toArray();

        // Separate arrays for predictions and created_at
        $predictionsonly = array_column($predictionsData, 'prediction');
        $createdAt = array_column($predictionsData, 'created_at');

        $k = 1;
        $predictions[0]['prediction'] = $predictionsonly;
        $predictions[0]['created_at'] = $createdAt;
        for ($i = 0; $i < count($iddevices); $i++) {
            $predictions[$k] = [];

            for ($j = 0; $j < count($predictionsall); $j++) {
                if ($predictionsall[$j]->device_id == $iddevices[$i]) {
                    $predictions[$k]['prediction'][] = $predictionsall[$j]->prediction;
                    $predictions[$k]['created_at'][] = $predictionsall[$j]->created_at;
                }
            }
            $k++;
        }
        // echo '<pre>';
        // print_r($predictions);
        // echo '</pre>';
        // exit;

        $latestprediction = DB::table('predictions')
            ->orderBy('id', 'desc')
            ->first();
        $devices = DB::table('devices')->get();

        // Memeriksa apakah $latestprediction ada sebelum mengakses prediction
        $prediksi = null;
        if ($latestprediction) {
            $prediksi = $latestprediction->prediction;
        }

        return view('backend.prediction.grafik', [
            'prediksi' => $prediksi,
            'device' => $devices
        ], compact('predictions'));
    }
}
