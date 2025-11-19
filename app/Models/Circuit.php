<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
    protected $fillable = ['gp_name', 'circuit_name', 'country'];

    // Satu sirkuit bisa punya banyak jadwal balapan (tiap tahun)
    public function races()
    {
        return $this->hasMany(Race::class);
    }
}
