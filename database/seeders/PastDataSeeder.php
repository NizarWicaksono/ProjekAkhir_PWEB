<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Race;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PastDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat User Dummy Pembeli
        $users = [];
        $names = ['Arvin', 'Ahmad', 'Adam', 'Daffa', 'Indra'];

        foreach ($names as $name) {
            $users[] = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $name)) . '@example.com'],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'role' => 'user'
                ]
            );
        }

        // 2. Buat 3 Balapan AWAL TAHUN 2025 (Sudah Lewat)
        $pastRaces = [
            [
                'name' => 'Australian Grand Prix 2025',
                'circuit_name' => 'Albert Park Circuit',
                'race_date' => Carbon::create(2025, 3, 16),
                'base_price' => 3500000,
            ],
            [
                'name' => 'Chinese Grand Prix 2025',
                'circuit_name' => 'Shanghai International Circuit',
                'race_date' => Carbon::create(2025, 3, 23),
                'base_price' => 2800000,
            ],
            [
                'name' => 'Japanese Grand Prix 2025',
                'circuit_name' => 'Suzuka International Racing Course',
                'race_date' => Carbon::create(2025, 4, 6),
                'base_price' => 2500000,
            ],
        ];

        foreach ($pastRaces as $raceData) {
            $race = Race::firstOrCreate(
                ['name' => $raceData['name']],
                $raceData
            );

            // 3. Generate Tiket (Semua Harga Sama)
            // Kita buat 15 tiket per balapan, 10 terjual
            for ($i = 1; $i <= 15; $i++) {
                $isSold = $i <= 10; // 10 tiket pertama terjual
                $buyer = $isSold ? $users[array_rand($users)] : null;

                Ticket::create([
                    'race_id' => $race->id,
                    'user_id' => $buyer ? $buyer->id : null,
                    'ticket_code' => '2025-' . strtoupper(Str::random(6)),

                    // PERUBAHAN DI SINI: Semua kategori dan harga sama
                    'category_name' => 'General Admission',
                    'price' => $race->base_price, // Harga ambil dari harga dasar race

                    'status' => $isSold ? 'sold' : 'available',
                    'purchase_date' => $isSold ? $race->race_date->subDays(rand(5, 60)) : null,
                ]);
            }
        }
    }
}
