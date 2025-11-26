<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        // Ambil data balapan
        $races = Jadwal::where('race_date', '>=', now())
                     ->orderBy('race_date', 'asc')
                     ->with('circuit')
                     ->paginate(6);

        // Perbaikan Logika: Cek dulu apakah user login
        if (Auth::check()) {
            // Kalau login, hitung tiketnya
            // Sesuaikan dengan model Ticket kamu, biasanya ada where('user_id', ...)
            $myTicketCount = \App\Models\Ticket::where('user_id', Auth::id())->count();
        } else {
            // Kalau guest, jumlah tiket pasti 0
            $myTicketCount = 0;
        }

        return view('users.tickets', compact('races', 'myTicketCount'));
    }

    // Proses Pembelian (Checkout)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'race_id' => 'required|exists:races,id', // Pastikan ID balapan valid
            'quantity' => 'required|integer|min:1|max:10', // Batasi max 10 tiket sekali beli
        ]);

        $race = Jadwal::findOrFail($request->race_id);

        // Hitung total harga (Hanya untuk info/log, yang disimpan per tiket)
        $totalPrice = $race->base_price * $request->quantity;

        // LOOPING: Buat tiket sebanyak quantity yang diminta
        for ($i = 0; $i < $request->quantity; $i++) {
            Ticket::create([
                'race_id' => $race->id,
                'user_id' => Auth::id(), // ID User yang sedang login
                'ticket_code' => 'F1-' . strtoupper(Str::random(8)), // Generate kode unik
                'category_name' => 'General Admission', // Default kategori
                'price' => $race->base_price, // Harga satuan
                'status' => 'sold', // Langsung kita anggap lunas (sold)
                'purchase_date' => now(),
            ]);
        }

        // Redirect kembali ke dashboard dengan pesan sukses
        return redirect()->route('tickets.index')->with('success', "Berhasil membeli {$request->quantity} tiket! Cek riwayat untuk detailnya.");
    }

    public function history()
    {
        // Ambil tiket milik user yang sedang login
        // Urutkan dari pembelian terbaru
        $tickets = Ticket::where('user_id', Auth::id())
                         ->where('status', 'sold')
                         ->with('race.circuit') // Load data balapan & sirkuit
                         ->orderByDesc('purchase_date')
                         ->get();

        return view('users.history', compact('tickets'));
    }

    public function downloadTicket($code)
    {
        $ticket = Ticket::where('ticket_code', $code)
                        ->where('user_id', Auth::id())
                        ->with('race.circuit')
                        ->firstOrFail();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.ticket', compact('ticket'));
        return $pdf->download('F1-Ticket-' . $ticket->ticket_code . '.pdf');
    }
}
