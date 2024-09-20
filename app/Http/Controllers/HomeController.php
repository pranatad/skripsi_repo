<?php

namespace App\Http\Controllers;

use App\Bibit;
use App\Barang;
use App\Departemen;
use App\Infrastruktur;
use App\Pengguna;
use App\Penjualan;
use App\Rekanan;
use App\Teknisi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua gambar dan kelompokkan berdasarkan tanggal upload
        $images = DB::table('images')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->get();

        // Hitung jumlah total gambar
        $totalImages = DB::table('images')->count();

        // Pisahkan data menjadi dua array: satu untuk label (tanggal), satu untuk data (jumlah gambar)
        $labels = $images->pluck('date')->toArray();
        $data = $images->pluck('total')->toArray();

        return view('backend.home', [
            'labels' => json_encode($labels),
            'data' => json_encode($data),
            'totalImages' => $totalImages,
        ]);
    }
}
