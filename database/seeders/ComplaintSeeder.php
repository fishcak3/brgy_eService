<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Complaint;
use App\Models\User;
use App\Models\ComplaintType;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have at least one resident user and staff
        $resident = User::where('role', 'resident')->first();
        $staff = User::where('role', 'staff')->first();
        $types = ComplaintType::all();

        if (!$resident || $types->isEmpty()) {
            $this->command->warn('⚠️ Skipping ComplaintSeeder: need at least 1 resident and complaint types.');
            return;
        }

        // Insert some sample complaints
        foreach (range(1, 5) as $i) {
            Complaint::create([
                'user_id' => $resident->id,
                'complaint_type_id' => $types->random()->id,
                'reference_no' => 'CMP-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'location' => fake()->streetAddress(),
                'priority' => fake()->randomElement(['low', 'normal', 'high', 'urgent']),
                'status' => fake()->randomElement(['open', 'pending', 'resolved']),
                'details' => fake()->sentence(12),
                'assigned_to' => $staff?->id,
                'remarks' => fake()->boolean(50) ? fake()->sentence(8) : null,
                'resolved_at' => fake()->boolean(30) ? Carbon::now()->subDays(rand(1, 10)) : null,
            ]);
        }
    }
}
