<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstateSubTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['type' => '1+kk'],
            ['type' => '1+1'],
            ['type' => '2+kk'],
            ['type' => '2+1'],
            ['type' => '3+kk'],
            ['type' => '3+1'],
            ['type' => '4+kk'],
            ['type' => '4+1'],
            ['type' => '5+kk'],
            ['type' => '5+1'],
            ['type' => '6 a více'],
            ['type' => 'Atypický'],
            ['type' => 'Rodinný'],
            ['type' => 'Vila'],
            ['type' => 'Chalupa'],
            ['type' => 'Chata'],
            ['type' => 'Na klíč'],
            ['type' => 'Zemědělská usedlost'],
            ['type' => 'Památka/jiné'],
            ['type' => 'Vícegenerační dům'],
            ['type' => 'Bydlení'],
            ['type' => 'Komerční'],
            ['type' => 'Pole'],
            ['type' => 'Louky'],
            ['type' => 'Lesy'],
            ['type' => 'Rybníky'],
            ['type' => 'Sady/vinice'],
            ['type' => 'Zahrady'],
            ['type' => 'Garáž'],
            ['type' => 'Garážové stání'],
            ['type' => 'Mobilheim'],
            ['type' => 'Vinný sklep'],
            ['type' => 'Půdní prostor'],
            ['type' => 'Ostatní'],
        ];

        DB::table('estate_sub_types')->insert($types);
    }
}
