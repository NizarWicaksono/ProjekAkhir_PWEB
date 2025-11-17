<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Redirect halaman awal langsung ke Login
Route::get('/', function () {
    // Opsional: Kalau user ternyata sudah login, lempar ke dashboard saja
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    // Kalau belum, paksa ke halaman login
    return redirect()->route('login');
});

// Group untuk Guest (yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

// Group untuk yang SUDAH Login (Auth)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
