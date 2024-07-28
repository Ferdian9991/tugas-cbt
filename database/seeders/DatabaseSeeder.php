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
            'name' => 'Admin CBT',
            'email' => 'admin@cbt.com',
            'password' => bcrypt('admin'),
            'phone' => fake()->phoneNumber,
            'role' => User::ROLE_ADMIN,
        ]);
    }
}
