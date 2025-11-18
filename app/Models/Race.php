<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $fillable = [
        'name',
        'circuit_name',
        'race_date',
        'base_price',
    ];

    // Casting agar 'race_date' otomatis jadi objek tanggal (Carbon)
    protected $casts = [
        'race_date' => 'date',
    ];
}
