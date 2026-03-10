<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SajagaReading;
use App\Models\SinatraReading;
use App\Models\NodeStatus;
use App\Models\EventLog;
use Illuminate\Http\Request;

class SensorController extends Controller {
    public function sajaga(Request $request) {
        $data = $request->validate([
            'node_id'    => 'required|string',
            'node_name'  => 'required|string',
            'tilt_angle' => 'required|numeric',
            'accel_x'    => 'required|numeric',
            'accel_y'    => 'required|numeric',
            'accel_z'    => 'required|numeric',
            'rainfall'   => 'required|numeric',
            'soil_moist' => 'required|numeric',
            'battery'    => 'nullable|numeric',
            'rssi'       => 'nullable|integer',
        ]);

        $status = SajagaReading::getStatus(
            $data['tilt_angle'],
            $data['rainfall'],
            $data['soil_moist']
        );

        $reading = SajagaReading::create([...$data, 'status' => $status]);

        // Update node status
        NodeStatus::updateOrCreate(
            ['node_id' => $data['node_id']],
            [
                'node_name' => $data['node_name'],
                'node_type' => 'TX',
                'is_online' => true,
                'last_seen' => now(),
                'battery'   => $data['battery'] ?? null,
                'rssi'      => $data['rssi'] ?? null,
            ]
        );

        // Log kalau WASPADA/BAHAYA
        if ($status !== 'AMAN') {
            EventLog::create([
                'system'      => 'SAJAGA',
                'node_id'     => $data['node_id'],
                'event_type'  => 'STATUS_CHANGE',
                'severity'    => $status === 'BAHAYA' ? 'DANGER' : 'WARNING',
                'title'       => "{$data['node_id']} masuk status {$status}",
                'description' => "Kemiringan: {$data['tilt_angle']}° | Hujan: {$data['rainfall']}mm | Kelembaban: {$data['soil_moist']}%",
            ]);
        }

        return response()->json([
            'success' => true,
            'data'    => ['id' => $reading->id, 'status' => $status],
            'message' => "Data {$data['node_id']} berhasil disimpan. Status: {$status}",
        ]);
    }

    public function sinatra(Request $request) {
        $data = $request->validate([
            'zone_id'    => 'required|string',
            'zone_name'  => 'required|string',
            'adc_raw'    => 'required|integer',
            'valve_open' => 'required|boolean',
        ]);

        $levelPct = SinatraReading::adcToPercent($data['adc_raw']);
        $status   = SinatraReading::getStatus($data['adc_raw']);

        $reading = SinatraReading::create([
            ...$data,
            'level_pct' => $levelPct,
            'status'    => $status,
        ]);

        EventLog::create([
            'system'      => 'SINATRA',
            'node_id'     => $data['zone_id'],
            'event_type'  => $data['valve_open'] ? 'VALVE_OPEN' : 'VALVE_CLOSE',
            'severity'    => 'INFO',
            'title'       => "{$data['zone_name']} — Katup " . ($data['valve_open'] ? 'Dibuka' : 'Ditutup'),
            'description' => "Level air: {$levelPct}% (ADC: {$data['adc_raw']})",
        ]);

        return response()->json([
            'success' => true,
            'data'    => ['id' => $reading->id, 'level_pct' => $levelPct, 'status' => $status],
            'message' => "Data {$data['zone_id']} berhasil disimpan. Level: {$levelPct}%",
        ]);
    }

    public function getSajaga() {
        $nodes = SajagaReading::getLatestPerNode();
        return response()->json(['success' => true, 'data' => $nodes]);
    }

    public function getSinatra() {
        $zones = SinatraReading::getLatestPerZone();
        return response()->json(['success' => true, 'data' => $zones]);
    }
}