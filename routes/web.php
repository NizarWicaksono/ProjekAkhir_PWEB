<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KeuanganController;
use App\Models\Article;
use App\Models\Jadwal;
use App\Models\Circuit;
use Illuminate\Http\Request;

// 1. Halaman Utama
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 2. Dashboard User
Route::get('/dashboard', function () {
    $articles = Article::latest()->get();
    $races = Race::where('race_date', '>=', now())
                 ->orderBy('race_date', 'asc')
                 ->take(5)
                 ->get();
    return view('dashboard', compact('articles', 'races'));
})->name('dashboard');

// 3. Guest (Login/Register)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

// 4. User Login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/booking/{id}', function ($id) {
        return "Halo! Ini halaman booking untuk Race ID: " . $id;
    })->name('booking.show');
});

// 5. ADMIN (Gunakan Controller Baru)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // === JADWAL (Pakai JadwalController) ===
    Route::get('/races', [JadwalController::class, 'index'])->name('admin.lihatjadwal');
    Route::get('/races/create', [JadwalController::class, 'create'])->name('admin.tambahjadwal');
    Route::post('/races', [JadwalController::class, 'store'])->name('admin.races.store');
    Route::delete('/races/{id}', [JadwalController::class, 'destroy'])->name('admin.races.destroy');

    // === KEUANGAN (Pakai KeuanganController) ===
    Route::get('/pendapatan', [KeuanganController::class, 'index'])->name('admin.pendapatan');
    Route::get('/pendapatan/{id}', [KeuanganController::class, 'show'])->name('admin.pendapatan.detail');
});
