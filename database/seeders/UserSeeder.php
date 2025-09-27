<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'El Gatto',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone_number' => '09171234567',
            'address' => 'Barangay Hall, Bakitiw',
            'birthdate' => '1990-01-01',
            'gender' => 'male',
            'household_no' => null,
            'purok' => null,
            'photo' => 'default/admin-boy.jpeg', 
        ]);

        User::create([
            'name' => 'Uncle Bao',
            'email' => 'staff@test.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'phone_number' => '09181234567',
            'address' => 'Bakitiw Zone 2',
            'birthdate' => '1995-05-15',
            'gender' => 'female',
            'household_no' => null,
            'purok' => 'Purok 2',
            'photo' => 'default/staff-girl.jpeg', 
        ]);

        User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'juan@test.com',
            'password' => Hash::make('password123'),
            'role' => 'resident',
            'phone_number' => '09221234567',
            'address' => '123 Bakitiw Street',
            'birthdate' => '2000-08-20',
            'gender' => 'male',
            'household_no' => '0001',
            'purok' => 'Purok 1',
            'photo' => 'default/resident-boy.jpeg', 
        ]);

        User::create([
            'name' => 'Maria Santos',
            'email' => 'maria@test.com',
            'password' => Hash::make('password123'),
            'role' => 'resident',
            'phone_number' => '09331234567',
            'address' => '456 Bakitiw Street',
            'birthdate' => '1998-03-10',
            'gender' => 'female',
            'household_no' => '0002',
            'purok' => 'Purok 3',
            'photo' => 'default/resident-girl.jpeg', 
        ]);
    }
}
