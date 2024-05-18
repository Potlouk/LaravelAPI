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
            ['type' => 'velmi dobrý'],
            ['type' => 'dobrý'],
            ['type' => 'špatný'],
            ['type' => 've výstavbě'],
            ['type' => 'developerské projekty'],
            ['type' => 'novostavba'],
            ['type' => 'k demolici'],
            ['type' => 'před rekonstrukcí'],
            ['type' => 'po rekonstrukci'],
            ['type' => 'v rekonstrukci'],
        ];

        DB::table('estate_conditions_types')->insert($conditions);
    }
}

