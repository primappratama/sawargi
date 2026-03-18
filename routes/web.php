<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SajagaController;
use App\Http\Controllers\Admin\SinatraController;

// ─── Public ───────────────────────────────────────────────
Route::get('/', function () {
    $sajagaNodes   = \App\Models\SajagaReading::getLatestPerNode();
    $sinatraZones  = \App\Models\SinatraReading::getLatestPerZone();
    $latestSensor  = \App\Models\SensorData::latest()->first();
    $sensorHistory = \App\Models\SensorData::orderBy('id','desc')->take(15)->get()->reverse()->values();
    $statusMap     = [0=>'AMAN', 1=>'WASPADA', 2=>'BAHAYA', 3=>'SANGAT BAHAYA'];
    $esp32Status   = $latestSensor ? ($statusMap[$latestSensor->status] ?? 'AMAN') : 'AMAN';
    return view('public.index', compact('sajagaNodes','sinatraZones','latestSensor','sensorHistory','esp32Status'));
})->name('public');

// ─── Realtime API (JSON) ───────────────────────────────────
Route::get('/api/realtime/status', function () {
    $sajagaNodes  = \App\Models\SajagaReading::getLatestPerNode();
    $sinatraZones = \App\Models\SinatraReading::getLatestPerZone();
    $latestSensor = \App\Models\SensorData::latest()->first();
    $statusMap    = [0=>'AMAN', 1=>'WASPADA', 2=>'BAHAYA', 3=>'SANGAT BAHAYA'];
    $esp32Status  = $latestSensor ? ($statusMap[$latestSensor->status] ?? 'AMAN') : null;

    $overall = 'AMAN';
    foreach ($sajagaNodes as $n) {
        if ($n->status === 'BAHAYA')  { $overall = 'BAHAYA';  break; }
        if ($n->status === 'WASPADA') { $overall = 'WASPADA'; }
    }

    return response()->json([
        'overall'      => $overall,
        'sajaga'       => $sajagaNodes->map(fn($n) => [
            'node_id'    => $n->node_id,
            'node_name'  => $n->node_name,
            'tilt_angle' => $n->tilt_angle,
            'rainfall'   => $n->rainfall,
            'soil_moist' => $n->soil_moist,
            'status'     => $n->status,
        ]),
        'sinatra'      => $sinatraZones->map(fn($z) => [
            'zone_id'   => $z->zone_id,
            'zone_name' => $z->zone_name,
            'level_pct' => $z->level_pct,
            'adc_raw'   => $z->adc_raw,
            'valve_open'=> $z->valve_open,
            'updated'   => $z->created_at->diffForHumans(),
        ]),
        'esp32'        => $latestSensor ? [
            'status'        => $esp32Status,
            'gyro_x'        => $latestSensor->gyro_x,
            'gyro_y'        => $latestSensor->gyro_y,
            'soil_moisture' => $latestSensor->soil_moisture,
            'suhu'          => $latestSensor->suhu,
            'rainfall'      => $latestSensor->rainfall,
            'updated'       => $latestSensor->created_at->diffForHumans(),
        ] : null,
        'timestamp'    => now()->format('H:i:s'),
    ]);
})->name('realtime.status');

// ─── Auth ─────────────────────────────────────────────────
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ─── Admin (protected) ────────────────────────────────────
Route::middleware('auth.admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/overview', [DashboardController::class, 'index'])->name('overview');
    Route::get('/sajaga',   [SajagaController::class, 'index'])->name('sajaga');
    Route::get('/sinatra',  [SinatraController::class, 'index'])->name('sinatra');
});