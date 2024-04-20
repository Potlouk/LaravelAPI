<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstateAdditionalEquipment extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            ['name' => 'Balkón'],
            ['name' => 'Terasa'],
            ['name' => 'Lodžie'],
            ['name' => 'Sklep'],
            ['name' => 'Zahrada'],
            ['name' => 'Parkování'],
            ['name' => 'Garáž'],
            ['name' => 'Výtah'],
            ['name' => 'Bezbariérový'],
            ['name' => 'Nízkoenergetický'],
            ['name' => 'Dřevostavba'],
            ['name' => 'Přízemní'],
            ['name' => 'Patrový'],
            ['name' => 'Samostatný'],
            ['name' => 'V bloku/řadový'],
            ['name' => 'Bazén'],
        ];

        DB::table('estate_additional_equipment')->insert($names);

    }
}
