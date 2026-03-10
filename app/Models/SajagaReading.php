<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SajagaReading extends Model {
    protected $fillable = [
        'node_id', 'node_name', 'tilt_angle',
        'accel_x', 'accel_y', 'accel_z',
        'rainfall', 'soil_moist', 'status',
        'battery', 'rssi',
    ];

    public static function getStatus(float $tiltAngle, float $rainfall, float $soilMoist): string {
        if ($tiltAngle > 2.0 || $rainfall > 70 || $soilMoist > 80) return 'BAHAYA';
        if ($tiltAngle >= 0.5 || $rainfall >= 20 || $soilMoist >= 50) return 'WASPADA';
        return 'AMAN';
    }

    public static function getLatestPerNode(): array {
        $nodes = ['TX-01', 'TX-02', 'TX-03'];
        $result = [];
        foreach ($nodes as $nodeId) {
            $latest = self::where('node_id', $nodeId)->latest()->first();
            if ($latest) $result[] = $latest;
        }
        return $result;
    }
}