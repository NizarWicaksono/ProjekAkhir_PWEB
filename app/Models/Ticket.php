<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'race_id',
        'user_id',
        'ticket_code',
        'category_name',
        'price',
        'status',
        'purchase_date'
    ];

    public function race()
    {
        return $this->belongsTo(Jadwal::class, 'race_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
