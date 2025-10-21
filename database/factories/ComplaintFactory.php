<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Complaint;
use App\Models\ComplaintType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Complaint>
 */
class ComplaintFactory extends Factory
{
    protected $model = Complaint::class;

    public function definition(): array
    {
        // Ensure at least one complaint type exists
        $complaintTypeId = ComplaintType::inRandomOrder()->value('id');

        // If none exist (fresh DB with no seeder yet), create a default one
        if (!$complaintTypeId) {
            $complaintTypeId = ComplaintType::create([
                'name' => 'Other',
                'description' => 'General complaints',
            ])->id;
        }

        return [
            'user_id' => User::factory(),
            'complaint_type_id' => $complaintTypeId,
            'reference_no' => strtoupper(Str::random(10)),
            'location' => $this->faker->address(),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'urgent']),
            'status' => $this->faker->randomElement(['open', 'in-progress', 'resolved', 'rejected']),
            'details' => $this->faker->paragraph(),
            'remarks' => $this->faker->optional()->sentence(),
            'assigned_to' => null,
            'resolved_at' => null,
        ];
    }
}
