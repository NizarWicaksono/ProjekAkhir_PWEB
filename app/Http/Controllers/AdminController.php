<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Article;


class AdminController extends Controller
{
    public function dashboard()
    {
        // Hitung data untuk statistik (Card Atas)
        $totalUsers = User::where('role', 'user')->count();
        $totalRaces = Race::count();
        $totalArticles = Article::count();

        // Nanti diganti dengan data real dari tabel transaksi
        $totalPendapatan = 0;

        return view('admin.dashboard', compact('totalUsers', 'totalRaces', 'totalArticles', 'totalPendapatan'));
    }
}
