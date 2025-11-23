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
        // 1. Ambil semua jadwal masa depan
        $races = Jadwal::with('circuit')
                    ->where('race_date', '>=', now())
                    ->orderBy('race_date', 'asc')
                    ->get();

        // 2. Hitung jumlah tiket yang dimiliki User yang sedang login
        $myTicketCount = Ticket::where('user_id', Auth::id())
                                ->where('status', 'sold')
                                ->count();

        return view('users.tickets', compact('races', 'myTicketCount'));
    }
    // 1. Tampilkan Halaman Booking (Detail Event + Form Jumlah)
    public function show($id)
    {
        // Ambil data jadwal beserta info sirkuitnya
        $race = Jadwal::with('circuit')->findOrFail($id);

        return view('users.booking', compact('race'));
    }

    // 2. Proses Pembelian (Checkout)
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
        return redirect()->route('users.dashboard')->with('success', "Pembayaran Berhasil! Anda telah membeli {$request->quantity} tiket.");
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
