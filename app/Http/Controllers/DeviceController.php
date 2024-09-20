<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    // Method untuk menampilkan daftar devices
    public function index()
    {
        $devices = Device::all(); // Ambil semua data devices dari tabel
        return view('backend.devices.index', compact('devices'));
    }

    // Method untuk menyimpan device baru
    public function store(Request $request)
    {
        $request->validate([
            'device_name' => 'required|string|max:255|unique:devices',
            'mac_address' => 'required|string|max:255',
        ]);

        $device = Device::create([
            'device_name' => $request->device_name,
            'mac_address' => $request->mac_address,
        ]);

        return response()->json([
            'message' => 'Device added successfully',
            'device' => $device
        ], 201);
    }

    // Method untuk menghapus device
    public function destroy($id)
    {
        $device = Device::findOrFail($id);
        $device->delete();

        return redirect()->route('devices.index')->with('success', 'Device deleted successfully');
    }
}
