<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SajagaReading;
use App\Models\SinatraReading;
use App\Models\NodeStatus;
use App\Models\EventLog;
use App\Models\SensorData;

class DashboardController extends Controller {
    public function index() {
        $sajagaNodes  = SajagaReading::getLatestPerNode();
        $sinatraZones = SinatraReading::getLatestPerZone();
        $nodeStatuses = NodeStatus::all();
        $recentEvents = EventLog::latest()->take(10)->get();

        // Overall status
        $overallStatus = 'AMAN';
        foreach ($sajagaNodes as $node) {
            if ($node->status === 'BAHAYA')  { $overallStatus = 'BAHAYA';  break; }
            if ($node->status === 'WASPADA') { $overallStatus = 'WASPADA'; }
        }

        $activeAlerts = collect($sajagaNodes)->where('status', '!=', 'AMAN')->count();

        // ESP32 sensor data
        $latestSensor  = SensorData::latest()->first();
        $sensorHistory = SensorData::orderBy('id','desc')->take(15)->get()->reverse()->values();
        $statusMap     = [0=>'AMAN', 1=>'WASPADA', 2=>'BAHAYA', 3=>'SANGAT BAHAYA'];
        $esp32Status   = $latestSensor ? ($statusMap[$latestSensor->status] ?? 'AMAN') : 'AMAN';

        return view('admin.overview', compact(
            'sajagaNodes', 'sinatraZones', 'nodeStatuses',
            'recentEvents', 'overallStatus', 'activeAlerts',
            'latestSensor', 'sensorHistory', 'esp32Status'
        ));
    }
}