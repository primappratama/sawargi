<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SinatraReading extends Model {
    protected $fillable = [
        'zone_id', 'zone_name', 'adc_raw',
        'level_pct', 'valve_open', 'status',
    ];

    public static function getStatus(int $adcRaw): string {
        if ($adcRaw >= 614) return 'BUKA';
        if ($adcRaw <= 307) return 'TUTUP';
        return 'HOLD';
    }

    public static function adcToPercent(int $adcRaw): float {
        return round(($adcRaw / 1023) * 100, 1);
    }

    public static function getLatestPerZone(): array {
        $zones = ['ZONA-1', 'ZONA-2'];
        $result = [];
        foreach ($zones as $zoneId) {
            $latest = self::where('zone_id', $zoneId)->latest()->first();
            if ($latest) $result[] = $latest;
        }
        return $result;
    }
}