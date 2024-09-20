<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceStatus extends Model
{
    protected $table = 'device_statuses'; // Sesuaikan dengan nama tabel di database Anda

    protected $fillable = [
        'mac_address', 'device_name', 'status',
    ];

    // Jika Anda tidak menggunakan timestamps (created_at dan updated_at)

    // Atau, jika Anda menggunakan timestamps, Anda bisa mengabaikan properti di atas
}
