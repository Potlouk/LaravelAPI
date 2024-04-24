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
            ['type' => 'atypický'],
            ['type' => 'chalupa'],
            ['type' => 'chata'],
            ['type' => 'rodinný'],
            ['type' => 'vila'],
            ['type' => 'na klíč'],
            ['type' => 'zemědělská usedlost'],
            ['type' => 'památka/jiné'],
            ['type' => 'vícegenerační dům'],
            ['type' => 'kanceláře'],
            ['type' => 'sklady'],
            ['type' => 'výroba'],
            ['type' => 'obchodní prostory'],
            ['type' => 'ubytování'],
            ['type' => 'restaurace'],
            ['type' => 'zemědělský'],
            ['type' => 'činžovní dům'],
            ['type' => 'ostatní'],
            ['type' => 'ordinace'],
            ['type' => 'apartmány'],
            ['type' => 'garáž'],
            ['type' => 'garážové stání'],
            ['type' => 'mobilheim'],
            ['type' => 'vinný sklep'],
            ['type' => 'půdní prostor'],
            ['type' => 'ostatní'],
            ['type' => 'Bydlení'],
            ['type' => 'komerční'],
            ['type' => 'ostatní'],
            ['type' => 'pole'],
            ['type' => 'lesy'],
            ['type' => 'rybníky'],
            ['type' => 'sady/vinice'],
            ['type' => 'zahrady'],
            ['type' => 'ostatní'],
        ];

        DB::table('estate_sub_types')->insert($types);
    }
}
