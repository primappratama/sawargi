<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorController as NodeRedController;
use App\Http\Controllers\SensorController as Esp32Controller;

// ─── SISTEM LO — Node-RED ────────────────────────────────
Route::post('/sensor/sajaga',  [NodeRedController::class, 'sajaga']);
Route::post('/sensor/sinatra', [NodeRedController::class, 'sinatra']);
Route::get('/sensor/sajaga',   [NodeRedController::class, 'getSajaga']);
Route::get('/sensor/sinatra',  [NodeRedController::class, 'getSinatra']);

// ─── SISTEM TEMEN — ESP32 ────────────────────────────────
Route::get('/get-bmkg-rain',   [Esp32Controller::class, 'getRainFromBMKG']);
Route::post('/data-sensor',    [Esp32Controller::class, 'store']);
Route::get('/data-sensor',     [Esp32Controller::class, 'index']);

// ─── STATUS CHECK ─────────────────────────────────────────
Route::get('/status', fn() => response()->json([
    'status' => 'SAWARGI Aktif',
    'time'   => now()
]));