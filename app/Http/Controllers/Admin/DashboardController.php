<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SajagaReading;
use App\Models\SinatraReading;
use App\Models\NodeStatus;
use App\Models\EventLog;

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

        return view('admin.overview', compact(
            'sajagaNodes', 'sinatraZones', 'nodeStatuses',
            'recentEvents', 'overallStatus', 'activeAlerts'
        ));
    }
}