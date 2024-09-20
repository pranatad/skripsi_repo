<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; // Import DB facade untuk menggunakan query builder
use RealRashid\SweetAlert\Facades\Alert;
use ConsoleTVs\Charts\Facades\Charts;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index()
    {
        $iddevices = DB::table('devices')->pluck('id')->toArray();
        $predictionsall = DB::table('devices')
            ->join('images', 'images.id_devices', '=', 'devices.id')
            ->join('predictions', 'predictions.id_images', '=', 'images.id')
            ->select('predictions.prediction', 'devices.id as device_id')
            ->get()
            ->toArray();

        $predictionsonly = DB::table('predictions')->pluck('prediction')->toArray();

        $k = 1;
        $predictions[0] = $predictionsonly;
        for ($i = 0; $i < count($iddevices); $i++) {
            $predictions[$k] = [];

            for ($j = 0; $j < count($predictionsall); $j++) {
                if ($predictionsall[$j]->device_id == $iddevices[$i]) {
                    $predictions[$k][] = $predictionsall[$j]->prediction;
                }
            }
            $k++;
        }

        $latestprediction = DB::table('predictions')
            ->orderBy('id', 'desc')
            ->first();
        $devices = DB::table('devices')->get();

        // Memeriksa apakah $latestprediction ada sebelum mengakses prediction
        $prediksi = null;
        if ($latestprediction) {
            $prediksi = $latestprediction->prediction;
        }

        return view('backend.prediction.upload', [
            'prediksi' => $prediksi,
            'device' => $devices
        ], compact('predictions'));
    }
}
