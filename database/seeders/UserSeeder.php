<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Resident;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resident = Resident::create([
            'fname' => 'Ivan',
            'mname' => 'De chavez',
            'lname' => 'Bugarin',
            'suffix' => null,
            'phone_number' => '09123456789',
            'birthdate' => '2002-06-05',
            'age' => 23,
            'sex' => 'male',
            'civil_status' => 'single',
            'region' => 'Region I',
            'province' => 'Pangasinan',
            'municipality' => 'Malasiqui',
            'barangay' => 'Aliaga',
            'street' => 'Tagurarit',
            'household_id' => 'HH-000',
            'solo_parent' => false,
            'ofw' => false,
            'is_pwd' => false,
            'is_4ps' => false,
            'out_of_school_children' => false,
            'osa' => false,
            'unemployed' => false,
            'laborforce' => true,
            'isy_isc' => false,
            'senior_citizen' => false,
            'voter' => true,
            'mother_maiden_name' => 'Marites De Chavez',
        ]);

        User::create([
            'resident_id' => $resident->id,
            'email' => 'admin@barangay.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'photo' => null,
        ]);
    }
}
