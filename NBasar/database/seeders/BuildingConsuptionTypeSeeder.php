<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingConsuptionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $energyRatings = [
            ['type' => 'A - Mimořádně úsporná'],
            ['type' => 'B - Velmi úsporná'],
            ['type' => 'C - Úsporná'],
            ['type' => 'D - Méně úsporná'],
            ['type' => 'E - Nehospodárná'],
            ['type' => 'F - Velmi nehospodárná'],
            ['type' => 'G - Mimořádně nehospodárná'],
        ];

        DB::table('estate_energy_consumptions')->insert($energyRatings);
    }
}
