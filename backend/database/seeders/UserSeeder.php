<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = new User([
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'test@test.test',
            'password' => bcrypt('root'),
            'watched_estates' => [],
            'reported_estates' => [],
        ]);

        $user->assignRole('User');
        $user->save();
    }
}
