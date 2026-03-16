<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    protected $table = 'sensor_data';

    protected $fillable = [
        'gyro_x',
        'gyro_y',
        'gyro_z',
        'soil_moisture',
        'rainfall',
        'suhu',
        'status',      // tambah ini
        'latitude',
        'longitude',
    ];
}