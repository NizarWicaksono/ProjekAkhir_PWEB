<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminRaceController;
use App\Models\Article;
use App\Models\Race;

// 1. Halaman Utama langsung ke Dashboard (Bisa diakses siapa saja)
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 2. Route Dashboard (PUBLIC / TIDAK PERLU LOGIN)
Route::get('/dashboard', function () {
    // Ambil data (gunakan dummy jika database kosong untuk mencegah error)
    // Kita gunakan 'try-catch' atau pengecekan sederhana

    $articles = Article::latest()->get();

    $races = Race::where('race_date', '>=', now())
                 ->orderBy('race_date', 'asc')
                 ->take(5)
                 ->get();

    return view('dashboard', compact('articles', 'races'));
})->name('dashboard');

// 3. Group untuk Tamu (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

// 4. Group untuk User LOGIN (Proteksi Pembelian)
Route::middleware('auth')->group(function () {

    // Fitur Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Fitur Beli Tiket (Hanya bisa diakses kalau sudah login)
    // Jika tamu klik tombol beli, Laravel otomatis melempar ke halaman Login
    Route::get('/booking/{id}', function ($id) {
        return "Halo! Ini halaman booking untuk Race ID: " . $id . ". Kamu melihat ini karena sudah login.";
        // Nanti kita ganti dengan Controller beneran: [BookingController::class, 'show']
    })->name('booking.show');
});

// GROUP ROUTE KHUSUS ADMIN
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Dashboard (yang sudah ada)
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // === ROUTE BARU UNTUK JADWAL ===
    Route::get('/races', [AdminRaceController::class, 'index'])->name('admin.races.index'); // Lihat List
    Route::get('/races/create', [AdminRaceController::class, 'create'])->name('admin.races.create'); // Form Tambah
    Route::post('/races', [AdminRaceController::class, 'store'])->name('admin.races.store'); // Proses Simpan
    Route::delete('/races/{id}', [AdminRaceController::class, 'destroy'])->name('admin.races.destroy'); // Hapus
});
