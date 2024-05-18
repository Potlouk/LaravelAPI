<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OwnershipTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $types = [
            ['type' => 'osobní'],
            ['type' => 'družstevní'],
            ['type' => 'státní/obecní'],
        ];

        DB::table('estate_ownership_types')->insert($types);
    }
}
