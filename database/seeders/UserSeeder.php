<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->create([
                'first_name' => 'Vinícius',
                'last_name' => 'Barros',
                'email' => 'minumex8@gmail.com',
                'password' => bcrypt('SenhaPadrao123456')
            ]);

        User::factory()
            ->count(10)
            ->create();
    }
}
