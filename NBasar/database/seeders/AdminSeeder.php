<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = new User([
            'name' => 'Super',
            'surname' => 'Admin',
            'email' => env('ADMIN_EMAIL'),
            'password' => bcrypt(env('ADMIN_PASSWORD')),
            'contacted_sellers' => [],
            'watched_estates' => [],
            'reported_estates' => [],
        ]);

        $admin->assignRole('Admin');
        $admin->save();
    }
}
