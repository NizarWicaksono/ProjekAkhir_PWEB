<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    // Hapus 'name' dan 'circuit_name' dari sini
    protected $fillable = [
        'circuit_id',
        'race_date',
        'base_price'
    ];

    protected $casts = [
        'race_date' => 'date',
    ];

    // Kebalikannya: Satu jadwal milik satu sirkuit
    public function circuit()
    {
        return $this->belongsTo(Circuit::class);
    }
}
