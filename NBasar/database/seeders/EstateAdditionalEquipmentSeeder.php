<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstateAdditionalEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            ['name' => 'balkón'],
            ['name' => 'terasa'],
            ['name' => 'lodžie'],
            ['name' => 'sklep'],
            ['name' => 'zahrada'],
            ['name' => 'parkování'],
            ['name' => 'garáž'],
            ['name' => 'výtah'],
            ['name' => 'bezbariérový'],
            ['name' => 'nízkoenergetický'],
            ['name' => 'dřevostavba'],
            ['name' => 'přízemní'],
            ['name' => 'patrový'],
            ['name' => 'samostatný'],
            ['name' => 'v bloku/řadový'],
            ['name' => 'bazén'],
        ];

        DB::table('estate_additional_equipment')->insert($names);

    }
}
