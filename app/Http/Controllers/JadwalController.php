<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Circuit;

// PERBAIKAN: Ubah nama class menjadi JadwalController (Sesuai nama file)
class JadwalController extends Controller
{
    // 1. Halaman List Jadwal
    public function index()
    {
        $races = Jadwal::with('circuit')->orderBy('race_date', 'desc')->get();
        return view('admin.lihatjadwal', compact('races'));
    }

    // 2. Halaman Form Tambah Jadwal
    public function create()
    {
        $circuits = Circuit::orderBy('gp_name', 'asc')->get();
        return view('admin.tambahjadwal', compact('circuits'));
    }

    // 3. Proses Simpan ke Database
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

    // 4. Hapus Jadwal
    public function destroy($id)
    {
        Jadwal::destroy($id);
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
