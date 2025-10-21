<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\DocumentRequest;
use App\Models\RequestType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DocumentRequest>
 */
class DocumentRequestFactory extends Factory
{
    protected $model = DocumentRequest::class;

    public function definition(): array
    {
        // Get a random request_type_id from seeded table
        $requestTypeId = RequestType::inRandomOrder()->value('id');

        // If none exist yet, create a default
        if (!$requestTypeId) {
            $requestTypeId = RequestType::create([
                'name' => 'Other',
                'description' => 'General request type',
                'fee' => 0,
                'status' => 'active',
            ])->id;
        }

        return [
            'user_id' => User::factory(),
            'request_type_id' => $requestTypeId,
            'reference_no' => strtoupper(Str::random(10)),
            'requested_date' => $this->faker->date(),
            'needed_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['pending', 'processing', 'approved', 'rejected']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'urgent']),
            'fee' => $this->faker->randomElement([0, 50, 100, 150, 300]),
            'details' => $this->faker->sentence(),
            'remarks' => $this->faker->optional()->sentence(),
            'assigned_to' => null,
            'completed_at' => null,
        ];
    }
}
