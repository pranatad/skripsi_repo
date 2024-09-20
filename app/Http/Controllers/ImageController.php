<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    public function index()
    {
        // Ambil semua gambar dengan join ke tabel devices untuk mendapatkan device_name
        $images = DB::table('images')
            ->join('devices', 'images.id_devices', '=', 'devices.id')
            ->join('predictions', 'predictions.id_images', '=', 'images.id')
            ->select('images.*', 'devices.device_name', 'predictions.prediction')
            ->get();

        return view('backend.images.index', [
            'images' => $images,
        ]);
    }

    public function destroy($id)
    {
        // Hapus prediksi yang terkait dengan gambar
        DB::table('predictions')->where('id_images', $id)->delete();
        // Hapus gambar
        DB::table('images')->where('id', $id)->delete();

        return redirect()->route('image')->with('success', 'Image deleted successfully');
    }
}
