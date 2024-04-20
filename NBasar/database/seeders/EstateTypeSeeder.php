<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['type' => 'Byty'],
            ['type' => 'Domy'],
            ['type' => 'Projekty'],
            ['type' => 'Pozemeky'],
            ['type' => 'Komercni'],
            ['type' => 'Ostatni'],
        ];

        DB::table('estate_types')->insert($types);
    }
}
