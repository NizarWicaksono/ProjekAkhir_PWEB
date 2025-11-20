<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Jadwal;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    public function index()
    {
        $totalRevenue = Ticket::where('status', 'sold')->sum('price');
        $totalTicketsSold = Ticket::where('status', 'sold')->count();

        // UPDATE: Tambahkan races.id ke select dan groupBy agar bisa dijadikan link
        $raceReports = Ticket::where('tickets.status', 'sold')
            ->join('races', 'tickets.race_id', '=', 'races.id')
            ->join('circuits', 'races.circuit_id', '=', 'circuits.id')
            ->select(
                'races.id as race_id', // <--- PENTING: Ambil ID Race
                'circuits.gp_name',
                'races.race_date',
                DB::raw('count(tickets.id) as sold_count'),
                DB::raw('sum(tickets.price) as total_income')
            )
            ->groupBy('races.id', 'circuits.gp_name', 'races.race_date') // Group by ID juga
            ->orderByDesc('total_income')
            ->get();

        $recentTransactions = Ticket::with(['user', 'race.circuit'])
            ->where('status', 'sold')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.pendapatan', compact('totalRevenue', 'totalTicketsSold', 'raceReports', 'recentTransactions'));
    }

    // === METHOD BARU UNTUK HALAMAN DETAIL ===
    public function show($id)
    {
        // 1. Ambil Data Balapan
        $race = Race::with('circuit')->findOrFail($id);

        // 2. Ambil Semua Transaksi Sold untuk Balapan ini
        $transactions = Ticket::where('race_id', $id)
            ->where('status', 'sold')
            ->with('user') // Ambil data pembeli
            ->orderByDesc('purchase_date') // Urutkan dari pembelian terakhir
            ->get();

        return view('admin.detailpendapatan', compact('race', 'transactions'));
    }
}
