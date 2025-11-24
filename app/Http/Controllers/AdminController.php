<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Article;
use App\Models\Ticket;


class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Hitung Statistik Dasar
        $totalUsers = User::where('role', 'user')->count();
        $totalRaces = Jadwal::count();
        $totalArticles = Article::count();

        // 2. Hitung Pendapatan & Tiket Terjual (Hanya yang 'sold')
        $totalPendapatan = Ticket::where('status', 'sold')->sum('price');
        $totalTickets = Ticket::where('status', 'sold')->count();

        // 3. Kirim semua data ke View
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRaces',
            'totalArticles',
            'totalPendapatan',
            'totalTickets'
        ));
    }
}
