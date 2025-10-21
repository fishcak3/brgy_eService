<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ComplaintType;
use App\Models\RequestType;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            PositionSeeder::class,
            ComplaintTypeSeeder::class,
            RequestTypeSeeder::class,
        ]);
    }
}
