<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Circuit;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PastDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat User Dummy Pembeli
        $users = [];
        $names = ['Leclerc', 'Verstappen', 'Lando', 'Lewis', 'Carlos'];

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

        // 2. Data Balapan Masa Lalu (Maret-April 2025)
        // KITA HANYA BUTUH NAMA GP, karena detail sirkuit diambil dari database
        $pastRaces = [
            [
                'gp_name' => 'Australian Grand Prix', // Harus sama persis dengan di CircuitSeeder
                'race_date' => Carbon::create(2025, 3, 16),
                'base_price' => 3500000,
            ],
            [
                'gp_name' => 'Chinese Grand Prix',
                'race_date' => Carbon::create(2025, 3, 23),
                'base_price' => 2800000,
            ],
            [
                'gp_name' => 'Japanese Grand Prix',
                'race_date' => Carbon::create(2025, 4, 6),
                'base_price' => 2500000,
            ],
        ];

        foreach ($pastRaces as $raceData) {
            // A. CARI CIRCUIT ID BERDASARKAN NAMA GP
            $circuit = Circuit::where('gp_name', $raceData['gp_name'])->first();

            // Jika sirkuit ketemu, baru buat jadwalnya
            if ($circuit) {
                // Gunakan firstOrCreate dengan 'circuit_id'
                $race = Jadwal::firstOrCreate(
                    [
                        'circuit_id' => $circuit->id, // <--- INI PERBAIKANNYA
                        'race_date' => $raceData['race_date']
                    ],
                    [
                        'base_price' => $raceData['base_price']
                    ]
                );

                // 3. Generate Tiket (Sama seperti sebelumnya)
                for ($i = 1; $i <= 15; $i++) {
                    $isSold = $i <= 10;
                    $buyer = $isSold ? $users[array_rand($users)] : null;

                    Ticket::create([
                        'race_id' => $race->id,
                        'user_id' => $buyer ? $buyer->id : null,
                        'ticket_code' => '2025-' . strtoupper(Str::random(6)),
                        'category_name' => 'General Admission',
                        'price' => $race->base_price,
                        'status' => $isSold ? 'sold' : 'available',
                        'purchase_date' => $isSold ? $race->race_date->subDays(rand(5, 60)) : null,
                    ]);
                }
            }
        }
    }
}
