<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
    protected $fillable = ['gp_name', 'circuit_name', 'country'];

    public function races() // Nama function boleh tetap races atau diganti jadwals
    {
        // PERBAIKAN: Ganti Race::class menjadi Jadwal::class
        return $this->hasMany(Jadwal::class, 'circuit_id');
    }
}
