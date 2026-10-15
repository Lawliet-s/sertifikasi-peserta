<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SkemaSertifikasiController;
use Illuminate\Support\Facades\Route;

// Redirect root ke dashboard jika sudah login, atau ke halaman login jika belum
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Route Tamu (Guest) dengan rate limiting (throttle)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

// Route Terproteksi (Admin)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('skema-sertifikasi', SkemaSertifikasiController::class);
    Route::resource('peserta', PesertaController::class)->parameters(['peserta' => 'peserta']);
});
