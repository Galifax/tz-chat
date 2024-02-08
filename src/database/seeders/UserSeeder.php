<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(['email' => 'example@gmail.com'])
            ->createOne();
        User::factory(9)
             ->create();
    }
}
