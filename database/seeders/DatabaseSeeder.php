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
        $this->call(CircuitSeeder::class);

        $this->call(PastDataSeeder::class);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@f1.com',
            'password' => Hash::make('admin123'), 
            'role' => 'admin',
        ]);
    }
}
