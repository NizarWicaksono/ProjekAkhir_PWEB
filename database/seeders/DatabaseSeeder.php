<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Admin',
            'email' => 'admin@f1.com',
            'password' => Hash::make('admin123'), // Password admin
            'role' => 'admin', // <--- KUNCI PENTING
        ]);
    }
}
