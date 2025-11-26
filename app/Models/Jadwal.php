<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'races';

    protected $fillable = [
        'circuit_id',
        'race_date',
        'base_price'
    ];

    protected $casts = [
    'race_date' => 'datetime',
    'base_price' => 'decimal:2',
    ];

    public function circuit()
    {
        return $this->belongsTo(Circuit::class);
    }
}
