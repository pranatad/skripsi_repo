<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $imageBase64 = $request->input('image_base64');

        DB::table('images')->insert([
            'image_base64' => $imageBase64,
        ]);

        return response()->json(['message' => 'Image uploaded successfully'], 200);
    }
}
