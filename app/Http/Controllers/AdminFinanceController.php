<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class AdminFinanceController extends Controller
{
    public function index()
    {
        // 1. Hitung Total Pendapatan (Semua Tiket Sold)
        $totalRevenue = Ticket::where('status', 'sold')->sum('price');

        // 2. Hitung Total Tiket Terjual
        $totalTicketsSold = Ticket::where('status', 'sold')->count();

        // 3. Laporan Per Balapan (Paling Laku)
        // Kita join 3 tabel: tickets -> races -> circuits
        $raceReports = Ticket::where('tickets.status', 'sold')
            ->join('races', 'tickets.race_id', '=', 'races.id')
            ->join('circuits', 'races.circuit_id', '=', 'circuits.id')
            ->select(
                'circuits.gp_name',
                'races.race_date',
                DB::raw('count(tickets.id) as sold_count'),
                DB::raw('sum(tickets.price) as total_income')
            )
            ->groupBy('circuits.gp_name', 'races.race_date')
            ->orderByDesc('total_income') // Urutkan dari pendapatan terbesar
            ->get();

        // 4. Transaksi Terbaru (5 Terakhir)
        $recentTransactions = Ticket::with(['user', 'race.circuit'])
            ->where('status', 'sold')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.pendapatan', compact('totalRevenue', 'totalTicketsSold', 'raceReports', 'recentTransactions'));
    }
}
