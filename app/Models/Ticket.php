<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'race_id', // Nama kolom di database tetap race_id (jangan diubah biar ga ribet migrasi)
        'user_id',
        'ticket_code',
        'category_name',
        'price',
        'status',
        'purchase_date'
    ];

    // Relasi ke Jadwal
    public function race()
    {
        // PERBAIKAN: Ganti Race::class menjadi Jadwal::class
        // Parameter kedua 'race_id' penting karena nama kolom FK kita masih 'race_id'
        return $this->belongsTo(Jadwal::class, 'race_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
