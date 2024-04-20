<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstateConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conditions = [
            ['type' => 'Velmi dobrý'],
            ['type' => 'Dobrý'],
            ['type' => 'Špatný'],
            ['type' => 'Ve výstavbě'],
            ['type' => 'Developerské projekty'],
            ['type' => 'Novostavba'],
            ['type' => 'K demolici'],
            ['type' => 'Před rekonstrukcí'],
            ['type' => 'Po rekonstrukci'],
            ['type' => 'V rekonstrukci'],
        ];

        DB::table('estate_conditions_types')->insert($conditions);
    }
}

