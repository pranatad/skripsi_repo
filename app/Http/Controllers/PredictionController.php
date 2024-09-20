<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB facade untuk menggunakan query builder
use RealRashid\SweetAlert\Facades\Alert;

class PredictionController extends Controller
{
    public function index()
    {
        $predictions = DB::table('predictions')->get()->toArray();
        $latestprediction = DB::table('predictions')
            ->orderBy('id', 'desc')
            ->first();

        $prediksi = null;
        if ($latestprediction) {
            $prediksi = $latestprediction->prediction;
        }
        // echo "<pre>";
        // print_r($predictions);
        // echo "</pre>";
        // exit;

        return view('backend.prediction.index', [
            'prediksi' => $prediksi
        ], compact('predictions'));
    }
}
