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
        $totalUsers = User::where('role', 'user')->count();
        $totalRaces = Jadwal::count();
        $totalArticles = Article::count();
        $totalPendapatan = Ticket::where('status', 'sold')->sum('price');
        $totalTickets = Ticket::where('status', 'sold')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRaces',
            'totalArticles',
            'totalPendapatan',
            'totalTickets'
        ));
    }
}
