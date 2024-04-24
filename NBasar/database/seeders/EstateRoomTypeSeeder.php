<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstateRoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            ['type' => '1 pokoj'],
            ['type' => '2 pokoje'],
            ['type' => '3 pokoje'],
            ['type' => '4 pokoje'],
            ['type' => '5 a více pokojů'],
            ['type' => 'atypický'],
        ];

        DB::table('estate_room_types')->insert($rooms);
    }
}
