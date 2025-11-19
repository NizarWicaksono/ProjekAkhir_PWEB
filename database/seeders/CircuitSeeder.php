<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Circuit;

class CircuitSeeder extends Seeder
{
    public function run()
    {
        $circuits = [
            // 1. Bahrain
            [
                'gp_name' => 'Bahrain Grand Prix',
                'circuit_name' => 'Bahrain International Circuit',
                'country' => 'Bahrain'
            ],
            // 2. Saudi Arabia
            [
                'gp_name' => 'Saudi Arabian Grand Prix',
                'circuit_name' => 'Jeddah Corniche Circuit',
                'country' => 'Saudi Arabia'
            ],
            // 3. Australia
            [
                'gp_name' => 'Australian Grand Prix',
                'circuit_name' => 'Albert Park Circuit',
                'country' => 'Australia'
            ],
            // 4. Japan
            [
                'gp_name' => 'Japanese Grand Prix',
                'circuit_name' => 'Suzuka International Racing Course',
                'country' => 'Japan'
            ],
            // 5. China
            [
                'gp_name' => 'Chinese Grand Prix',
                'circuit_name' => 'Shanghai International Circuit',
                'country' => 'China'
            ],
            // 6. Miami (USA)
            [
                'gp_name' => 'Miami Grand Prix',
                'circuit_name' => 'Miami International Autodrome',
                'country' => 'USA'
            ],
            // 7. Emilia Romagna (Italy)
            [
                'gp_name' => 'Emilia Romagna Grand Prix',
                'circuit_name' => 'Autodromo Enzo e Dino Ferrari (Imola)',
                'country' => 'Italy'
            ],
            // 8. Monaco
            [
                'gp_name' => 'Monaco Grand Prix',
                'circuit_name' => 'Circuit de Monaco',
                'country' => 'Monaco'
            ],
            // 9. Canada
            [
                'gp_name' => 'Canadian Grand Prix',
                'circuit_name' => 'Circuit Gilles-Villeneuve',
                'country' => 'Canada'
            ],
            // 10. Spain
            [
                'gp_name' => 'Spanish Grand Prix',
                'circuit_name' => 'Circuit de Barcelona-Catalunya',
                'country' => 'Spain'
            ],
            // 11. Austria
            [
                'gp_name' => 'Austrian Grand Prix',
                'circuit_name' => 'Red Bull Ring',
                'country' => 'Austria'
            ],
            // 12. Great Britain
            [
                'gp_name' => 'British Grand Prix',
                'circuit_name' => 'Silverstone Circuit',
                'country' => 'United Kingdom'
            ],
            // 13. Hungary
            [
                'gp_name' => 'Hungarian Grand Prix',
                'circuit_name' => 'Hungaroring',
                'country' => 'Hungary'
            ],
            // 14. Belgium
            [
                'gp_name' => 'Belgian Grand Prix',
                'circuit_name' => 'Circuit de Spa-Francorchamps',
                'country' => 'Belgium'
            ],
            // 15. Netherlands
            [
                'gp_name' => 'Dutch Grand Prix',
                'circuit_name' => 'Circuit Zandvoort',
                'country' => 'Netherlands'
            ],
            // 16. Italy (Monza)
            [
                'gp_name' => 'Italian Grand Prix',
                'circuit_name' => 'Autodromo Nazionale Monza',
                'country' => 'Italy'
            ],
            // 17. Azerbaijan
            [
                'gp_name' => 'Azerbaijan Grand Prix',
                'circuit_name' => 'Baku City Circuit',
                'country' => 'Azerbaijan'
            ],
            // 18. Singapore
            [
                'gp_name' => 'Singapore Grand Prix',
                'circuit_name' => 'Marina Bay Street Circuit',
                'country' => 'Singapore'
            ],
            // 19. USA (Austin)
            [
                'gp_name' => 'United States Grand Prix',
                'circuit_name' => 'Circuit of The Americas',
                'country' => 'USA'
            ],
            // 20. Mexico
            [
                'gp_name' => 'Mexico City Grand Prix',
                'circuit_name' => 'Autodromo Hermanos Rodriguez',
                'country' => 'Mexico'
            ],
            // 21. Brazil
            [
                'gp_name' => 'São Paulo Grand Prix',
                'circuit_name' => 'Autodromo Jose Carlos Pace (Interlagos)',
                'country' => 'Brazil'
            ],
            // 22. Las Vegas (USA)
            [
                'gp_name' => 'Las Vegas Grand Prix',
                'circuit_name' => 'Las Vegas Strip Circuit',
                'country' => 'USA'
            ],
            // 23. Qatar
            [
                'gp_name' => 'Qatar Grand Prix',
                'circuit_name' => 'Lusail International Circuit',
                'country' => 'Qatar'
            ],
            // 24. Abu Dhabi
            [
                'gp_name' => 'Abu Dhabi Grand Prix',
                'circuit_name' => 'Yas Marina Circuit',
                'country' => 'UAE'
            ],
        ];

        foreach ($circuits as $circuit) {
            Circuit::create($circuit);
        }
    }
}
