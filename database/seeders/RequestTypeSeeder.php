<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RequestType;

class RequestTypeSeeder extends Seeder
{
    public function run(): void
    {
        RequestType::insert([
            ['name' => 'Barangay Clearance', 'description' => 'For employment, school, or business'],
            ['name' => 'Barangay ID', 'description' => 'Proof of residency'],
            ['name' => 'Indigency Certificate', 'description' => 'For financial or legal assistance'],
        ]);
    }
}
