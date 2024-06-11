<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // First Admin account
        User::factory()->create([
            'name' => 'Test User 1',
            'email' => 'admin1@example.com',
            'role' => 'admin',
            'password' => bcrypt('admin1'), 
        ]);

        // Second Admin account
        User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'admin2@example.com',
            'role' => 'admin',
            'password' => bcrypt('admin2'), 
        ]);
    }
}

