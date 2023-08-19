<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypesSeeder extends Seeder
{
    public function run(): void
    {
        Type::firstOrCreate(
            ['name' => 'PJ'],
            ['name' => 'PJ']
        );

        Type::firstOrCreate(
            ['name' => 'PF'],
            ['name' => 'PF']
        );
    }
}
