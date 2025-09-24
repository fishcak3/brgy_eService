<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('request_types')->insert([
            [
                'name' => 'Barangay Clearance',
                'description' => 'Certification that the resident is of good standing and has no pending cases in the barangay.',
                'fee' => 50.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Certificate of Indigency',
                'description' => 'Issued to certify that a resident belongs to an indigent family.',
                'fee' => 0.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Business Permit',
                'description' => 'Permit required to operate a business within the barangay.',
                'fee' => 300.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Barangay ID',
                'description' => 'Official identification issued by the barangay.',
                'fee' => 100.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Residency Certificate',
                'description' => 'Document certifying that the individual is a bona fide resident of the barangay.',
                'fee' => 50.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Travel/Working Permit',
                'description' => 'Permit issued for residents who need authorization to travel or work.',
                'fee' => 150.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
