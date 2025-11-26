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

        // Join pakai nama TABEL ('races'), jadi ini TIDAK PERLU diganti ke 'jadwals'
        $raceReports = Ticket::where('tickets.status', 'sold')
            ->join('races', 'tickets.race_id', '=', 'races.id')
            ->join('circuits', 'races.circuit_id', '=', 'circuits.id')
            ->select(
                'races.id as race_id',
                'circuits.gp_name',
                'races.race_date',
                DB::raw('count(tickets.id) as sold_count'),
                DB::raw('sum(tickets.price) as total_income')
            )
            ->groupBy('races.id', 'circuits.gp_name', 'races.race_date')
            ->orderByDesc('total_income')
            ->paginate(10);

        $recentTransactions = Ticket::with(['user', 'race.circuit'])
            ->where('status', 'sold')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.pendapatan', compact('totalRevenue', 'totalTicketsSold', 'raceReports', 'recentTransactions'));
    }

    public function show($id)
    {
        // PERBAIKAN: Ganti Race:: menjadi Jadwal::
        $race = Jadwal::with('circuit')->findOrFail($id);

        $transactions = Ticket::where('race_id', $id)
            ->where('status', 'sold')
            ->with('user')
            ->orderByDesc('purchase_date')
            ->get();

        return view('admin.detailpendapatan', compact('race', 'transactions'));
    }
}
