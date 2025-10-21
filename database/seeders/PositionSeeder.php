<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['title' => 'Barangay Captain', 'description' => 'Head of the Barangay Government Unit'],
            ['title' => 'Barangay Secretary', 'description' => 'Responsible for official records and documentation'],
            ['title' => 'Barangay Treasurer', 'description' => 'Manages the barangay’s funds and finances'],
            ['title' => 'Barangay Kagawad (Committee on Peace and Order)', 'description' => 'Oversees peace and order matters'],
            ['title' => 'Barangay Kagawad (Committee on Health)', 'description' => 'Handles health and sanitation programs'],
            ['title' => 'Barangay Kagawad (Committee on Education)', 'description' => 'In charge of educational initiatives'],
            ['title' => 'Barangay Kagawad (Committee on Infrastructure)', 'description' => 'Supervises barangay construction and maintenance'],
            ['title' => 'Barangay Kagawad (Committee on Agriculture)', 'description' => 'Promotes agricultural projects'],
            ['title' => 'Barangay Kagawad (Committee on Youth and Sports)', 'description' => 'Handles youth and sports development'],
            ['title' => 'SK Chairperson', 'description' => 'Leads the Sangguniang Kabataan (Youth Council)'],
            ['title' => 'SK Secretary', 'description' => 'Responsible for SK documentation and correspondence'],
            ['title' => 'SK Treasurer', 'description' => 'Manages SK financial transactions'],
            ['title' => 'Barangay Tanod', 'description' => 'Maintains peace and assists in security duties'],
            ['title' => 'Barangay Health Worker', 'description' => 'Provides basic health services to residents'],
            ['title' => 'Barangay Clerk', 'description' => 'Assists in administrative and clerical duties'],
        ];

        foreach ($positions as $position) {
            Position::updateOrCreate(
                ['title' => $position['title']],
                [
                    'description' => $position['description'],
                    'max_members' => 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
