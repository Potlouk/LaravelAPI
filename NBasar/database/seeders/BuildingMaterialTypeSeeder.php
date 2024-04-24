<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingMaterialTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['type' => 'cihla'],
            ['type' => 'panel'],
            ['type' => 'ostatní'],
        ];

        DB::table('estate_building_material_types')->insert($types);
    }
}
