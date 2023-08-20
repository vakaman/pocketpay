<?php

namespace Database\Seeders;

use App\Models\EconomicActivitie;
use Illuminate\Database\Seeder;

class EconomicActivitiesSeeder extends Seeder
{
    public function run(): void
    {
        EconomicActivitie::firstOrCreate(
            ['code' => '0000-1/01'],
            [
                'id' => 1,
                'name' => 'Natural Person',
                'code' => '0000-1/01',
                'type_id' => 2
            ],
        );

        EconomicActivitie::firstOrCreate(
            ['code' => '4712-1/00'],
            [
                'id' => 2,
                'name' => 'Retail trade',
                'code' => '4712-1/00',
                'type_id' => 1
            ],
        );
    }
}
