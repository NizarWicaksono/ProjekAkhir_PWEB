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
        $races = Jadwal::where('race_date', '>=', now())
                     ->orderBy('race_date', 'desc')
                     ->with('circuit')
                     ->paginate(6);

        if (Auth::check()) {
            $myTicketCount = \App\Models\Ticket::where('user_id', Auth::id())->count();
        } else {
            $myTicketCount = 0;
        }

        return view('users.tickets', compact('races', 'myTicketCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'race_id' => 'required|exists:races,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $race = Jadwal::findOrFail($request->race_id);

        $totalPrice = $race->base_price * $request->quantity;

        for ($i = 0; $i < $request->quantity; $i++) {
            Ticket::create([
                'race_id' => $race->id,
                'user_id' => Auth::id(),
                'ticket_code' => 'F1-' . strtoupper(Str::random(8)),
                'category_name' => 'General Admission',
                'price' => $race->base_price,
                'status' => 'sold',
                'purchase_date' => now(),
            ]);
        }

        return redirect()->route('tickets.index')->with('success', "Berhasil membeli {$request->quantity} tiket! Cek riwayat untuk detailnya.");
    }

    public function history()
    {
        $tickets = Ticket::where('user_id', Auth::id())
                         ->where('status', 'sold')
                         ->with('race.circuit')
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
