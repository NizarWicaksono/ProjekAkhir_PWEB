<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Race;
use App\Models\Circuit;

class AdminRaceController extends Controller
{
    // 1. Halaman List Jadwal
    public function index()
    {
        // AMBIL SEMUA DATA SIRKUIT UNTUK DROPDOWN
        // Urutkan berdasarkan nama GP biar rapi
        $races = Race::with('circuit')->orderBy('race_date', 'desc')->get();
        // Kirim variabel $circuits ke view
        return view('admin.lihatjadwal', compact('races'));
    }

    // 2. Halaman Form Tambah Jadwal
    public function create()
    {
        // Ambil semua data sirkuit lengkap (ID, Nama GP, Nama Sirkuit, Negara)
        $circuits = Circuit::orderBy('gp_name', 'asc')->get();
        
        return view('admin.tambahjadwal', compact('circuits'));
    }

    // 3. Proses Simpan ke Database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'circuit_id' => 'required|exists:circuits,id', // Validasi ID harus ada di tabel circuits
            'race_date' => 'required|date',
            'base_price' => 'required|numeric|min:0',
        ]);

        // Simpan data
        Race::create([
            'circuit_id' => $request->circuit_id,
            'race_date' => $request->race_date,
            'base_price' => $request->base_price,
        ]);

        return redirect()->route('admin.lihatjadwal')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    // 4. Hapus Jadwal (Bonus)
    public function destroy($id)
    {
        Race::destroy($id);
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
