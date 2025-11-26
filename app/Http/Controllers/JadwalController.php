<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Circuit;

class JadwalController extends Controller
{
    public function index()
    {
        $activeRaces = Jadwal::with('circuit')
                        ->whereDate('race_date', '>=', now())
                        ->orderBy('race_date', 'desc')
                        ->paginate(8, ['*'], 'active_page');

        $pastRaces = Jadwal::with('circuit')
                        ->whereDate('race_date', '<', now())
                        ->orderBy('race_date', 'desc')
                        ->paginate(8, ['*'], 'past_page');

        $circuits = Circuit::orderBy('gp_name', 'asc')->get();

        return view('admin.lihatjadwal', compact('activeRaces', 'pastRaces', 'circuits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'circuit_id' => 'required|exists:circuits,id',
            'race_date' => 'required|date',
            'base_price' => 'required|numeric|min:0',
        ]);

        Jadwal::create([
            'circuit_id' => $request->circuit_id,
            'race_date' => $request->race_date,
            'base_price' => $request->base_price,
        ]);

        return redirect()->route('admin.lihatjadwal')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'circuit_id' => 'required|exists:circuits,id',
            'race_date' => 'required|date',
            'base_price' => 'required|numeric|min:0',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update([
            'circuit_id' => $request->circuit_id,
            'race_date' => $request->race_date,
            'base_price' => $request->base_price,
        ]);

        return redirect()->route('admin.lihatjadwal')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Jadwal::destroy($id);
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
