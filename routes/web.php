<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ArticleController;
use App\Models\Article;
use App\Models\Jadwal;
use App\Models\Circuit;
use Illuminate\Http\Request;

// 1. Halaman Utama
Route::get('/', function () {
    return redirect()->route('users.dashboard');
});

// 2. Dashboard User
Route::get('/dashboard', function () {
    $articles = Article::latest()->paginate(6);

    $races = Jadwal::where('race_date', '>=', now())
                 ->orderBy('race_date', 'asc')
                 ->take(4)
                 ->get();

    return view('users.dashboard', compact('articles', 'races'));
})->name('users.dashboard');

Route::get('/news/{id}', [ArticleController::class, 'showPublic'])->name('news.show');
// ROUTE BARU: Halaman List Tiket
Route::get('/tickets', [BookingController::class, 'index'])->name('tickets.index');

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
    // 1. Halaman Form Booking (GET)
    Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.show');
    // 2. Proses Simpan/Bayar (POST)
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    // Route Proses Bayar
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    // ROUTE BARU: Riwayat
    Route::get('/history', [BookingController::class, 'history'])->name('users.history');
    // Route Download Tiket
    Route::get('/ticket/{code}/download', [BookingController::class, 'downloadTicket'])->name('ticket.download');
    // Route Profil User
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('users.profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('users.profile.update');
});

// 5. ADMIN (Gunakan Controller Baru)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // === JADWAL (Pakai JadwalController) ===
    Route::get('/races', [JadwalController::class, 'index'])->name('admin.lihatjadwal');
    Route::post('/races', [JadwalController::class, 'store'])->name('admin.races.store');
    Route::delete('/races/{id}', [JadwalController::class, 'destroy'])->name('admin.races.destroy');

    // === KEUANGAN (Pakai KeuanganController) ===
    Route::get('/pendapatan', [KeuanganController::class, 'index'])->name('admin.pendapatan');
    Route::get('/pendapatan/{id}', [KeuanganController::class, 'show'])->name('admin.pendapatan.detail');

    // === MANAJEMEN ARTIKEL ===
    Route::get('/articles', [ArticleController::class, 'index'])->name('admin.articles.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('admin.articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('admin.articles.store');
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('admin.articles.show'); // Lihat Detail
    Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('admin.articles.update'); // Update
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('admin.articles.destroy');
});
