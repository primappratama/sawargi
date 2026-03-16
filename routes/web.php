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