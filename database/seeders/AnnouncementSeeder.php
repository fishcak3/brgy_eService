<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        Announcement::create([
            'title' => 'Community Clean-up Drive',
            'content' => 'Join us this Saturday for the barangay clean-up drive starting at 7 AM.',
            'user_id' => 1,
        ]);


        Announcement::create([
            'title' => 'Water Service Interruption',
            'content' => 'Please be advised that there will be a water service interruption on Sept 25.',
            'user_id' => 1,
        ]);

        Announcement::create([
            'user_id' => 1,
            'title' => 'Emergency Preparedness Drill',
            'content' => 'There will be an earthquake and fire drill on October 20 at 9 AM.',
        ]);

        Announcement::create([
            'user_id' =>2,
            'title' => 'Youth Sports League',
            'content' => 'Registration for the youth basketball league is now open until September 30.',
        ]);

        Announcement::create([
            'user_id' => 2,
            'title' => 'Fiesta Celebration',
            'content' => 'Barangay fiesta celebration will start on November 15. Everyone is invited.',
        ]);

        Announcement::create([
            'user_id' => 1,
            'title' => 'Health Mission',
            'content' => 'A free health mission will be conducted on October 10 at the covered court.',
        ]);
        
    }
}
