<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceStatus;

class Esp32CamController extends Controller
{
    public function connect(Request $request)
    {
        $data = $request->validate([
            'mac_address' => 'required|string',
            'device_name' => 'required|string',
        ]);

        $data['status'] = 'connected';

        DeviceStatus::create($data);

        return response()->json(['message' => 'Data inserted successfully']);
    }
}
