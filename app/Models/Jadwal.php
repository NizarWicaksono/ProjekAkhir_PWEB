<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    // PENTING: Karena nama model 'Jadwal' tapi tabelnya 'races', kita harus definisikan ini:
    protected $table = 'races';

    protected $fillable = [
        'circuit_id',
        'race_date',
        'base_price'
    ];

    protected $casts = [
        'race_date' => 'date',
    ];

    public function circuit()
    {
        return $this->belongsTo(Circuit::class);
    }
}
