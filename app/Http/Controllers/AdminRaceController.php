<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Race;

class AdminRaceController extends Controller
{
    // 1. Halaman List Jadwal
    public function index()
    {
        $races = Race::orderBy('race_date', 'asc')->get();
        return view('admin.races.index', compact('races'));
    }

    // 2. Halaman Form Tambah Jadwal
    public function create()
    {
        return view('admin.races.create');
    }

    // 3. Proses Simpan ke Database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'circuit_name' => 'required|string|max:255',
            'race_date' => 'required|date',
            'base_price' => 'required|numeric|min:0',
        ]);

        // Simpan data
        Race::create([
            'name' => $request->name,
            'circuit_name' => $request->circuit_name,
            'race_date' => $request->race_date,
            'base_price' => $request->base_price,
        ]);

        return redirect()->route('admin.races.index')->with('success', 'Jadwal balapan berhasil ditambahkan!');
    }

    // 4. Hapus Jadwal (Bonus)
    public function destroy($id)
    {
        Race::destroy($id);
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
