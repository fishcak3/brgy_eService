<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplaintTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Noise Disturbance',
                'description' => 'Complaints related to loud music, parties, or other noise disturbances.',
            ],
            [
                'name' => 'Garbage Collection',
                'description' => 'Issues with uncollected garbage, improper disposal, or waste management.',
            ],
            [
                'name' => 'Water Supply',
                'description' => 'Concerns about water supply interruptions, leaks, or contamination.',
            ],
            [
                'name' => 'Road and Infrastructure',
                'description' => 'Complaints about damaged roads, sidewalks, streetlights, or drainage.',
            ],
            [
                'name' => 'Vandalism',
                'description' => 'Reports of vandalism, graffiti, or intentional property damage.',
            ],
            [
                'name' => 'Other',
                'description' => 'General complaints not covered by the predefined categories.',
            ],
        ];

        foreach ($types as $type) {
            DB::table('complaint_types')->updateOrInsert(
                ['name' => $type['name']], // Prevent duplicates
                $type
            );
        }
    }
}
