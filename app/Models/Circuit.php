<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
    protected $fillable = ['gp_name', 'circuit_name', 'country'];

    public function races()
    {
        return $this->hasMany(Jadwal::class, 'circuit_id');
    }
}
