<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorController;

// ─── Sensor endpoints (dipanggil Node-RED) ────────────────
Route::post('/sensor/sajaga',  [SensorController::class, 'sajaga']);
Route::post('/sensor/sinatra', [SensorController::class, 'sinatra']);
Route::get('/sensor/sajaga',   [SensorController::class, 'getSajaga']);
Route::get('/sensor/sinatra',  [SensorController::class, 'getSinatra']);