<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SajagaController;
use App\Http\Controllers\Admin\SinatraController;

// ─── Public ───────────────────────────────────────────────
Route::get('/', function () {
    $sajagaNodes  = \App\Models\SajagaReading::getLatestPerNode();
    $sinatraZones = \App\Models\SinatraReading::getLatestPerZone();
    return view('public.index', compact('sajagaNodes', 'sinatraZones'));
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