<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SinatraReading;

class SinatraController extends Controller {
    public function index() {
        $zones = SinatraReading::getLatestPerZone();

        $zoneList = [
            ['id' => 'ZONA-1', 'name' => 'Bak Kontrol Utama',      'pipe' => '3" HDPE'],
            ['id' => 'ZONA-2', 'name' => 'Bak Distribusi Sekunder', 'pipe' => '4" HDPE'],
        ];

        return view('admin.sinatra', compact('zones', 'zoneList'));
    }
}