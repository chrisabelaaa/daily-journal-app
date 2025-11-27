<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'abey',
            'email' => 'abey@gmail.com',
            'password' => bcrypt('110807'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Usher User',
            'email' => 'usher@example.com',
            'role' => 'admin',
        ]);
    }
}
