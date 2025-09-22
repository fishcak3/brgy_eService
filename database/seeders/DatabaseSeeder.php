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
        User::create([
    'name' => 'Resident User',
    'email' => 'resident@test.com',
    'password' => bcrypt('password123'),
    'role' => 'resident',
]);

User::create([
    'name' => 'Staff User',
    'email' => 'staff@test.com',
    'password' => bcrypt('password123'),
    'role' => 'staff',
]);

User::create([
    'name' => 'Super Admin',
    'email' => 'admin@test.com',
    'password' => bcrypt('password123'),
    'role' => 'admin',
]);

    }
}
