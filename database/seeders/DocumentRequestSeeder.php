<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentRequest;
use App\Models\User;
use App\Models\RequestType;
use Illuminate\Support\Str;

class DocumentRequestSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have at least one resident and one staff
        $resident = User::firstOrCreate(
            ['email' => 'resident@test.com'],
            [
                'name' => 'Resident User',
                'password' => bcrypt('password123'),
                'role' => 'resident',
            ]
        );

        $staff = User::firstOrCreate(
            ['email' => 'staff@test.com'],
            [
                'name' => 'Staff User',
                'password' => bcrypt('password123'),
                'role' => 'staff',
            ]
        );

        // Ensure request types exist (self-healing)
        $barangayClearance = RequestType::firstOrCreate(
            ['name' => 'Barangay Clearance'],
            [
                'description' => 'Certification that the resident is of good standing.',
                'fee' => 50.00,
                'status' => 'active',
            ]
        );

        $indigency = RequestType::firstOrCreate(
            ['name' => 'Certificate of Indigency'],
            [
                'description' => 'Issued to certify that a resident belongs to an indigent family.',
                'fee' => 0.00,
                'status' => 'active',
            ]
        );

        $residency = RequestType::firstOrCreate(
            ['name' => 'Residency Certificate'],
            [
                'description' => 'Document certifying that the individual is a bona fide resident.',
                'fee' => 50.00,
                'status' => 'active',
            ]
        );

        // Create sample document requests
        DocumentRequest::create([
            'user_id' => $resident->id,
            'request_type_id' => $barangayClearance->id,
            'reference_no' => strtoupper(Str::random(10)),
            'requested_date' => now(),
            'needed_date' => now()->addDays(3),
            'status' => 'pending',
            'priority' => 'medium',
            'fee' => $barangayClearance->fee,
            'details' => 'Requesting clearance for job application.',
            'assigned_to' => $staff->id,
        ]);

        DocumentRequest::create([
            'user_id' => $resident->id,
            'request_type_id' => $indigency->id,
            'reference_no' => strtoupper(Str::random(10)),
            'requested_date' => now(),
            'needed_date' => now()->addDays(1),
            'status' => 'processing',
            'priority' => 'high',
            'fee' => $indigency->fee,
            'details' => 'For scholarship requirement.',
            'assigned_to' => $staff->id,
        ]);

        DocumentRequest::create([
            'user_id' => $resident->id,
            'request_type_id' => $residency->id,
            'reference_no' => strtoupper(Str::random(10)),
            'requested_date' => now()->subDays(5),
            'needed_date' => now()->subDays(2),
            'status' => 'completed',
            'priority' => 'low',
            'fee' => $residency->fee,
            'details' => 'Proof of residency for government ID application.',
            'assigned_to' => $staff->id,
            'completed_at' => now(),
        ]);
    }
}
