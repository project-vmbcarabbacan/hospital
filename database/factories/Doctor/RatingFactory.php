<?php

namespace Database\Factories\Doctor;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $doctor = User::where('role_id', 2)->inRandomOrder()->first()
            ?? User::factory()->create(['role_id' => 2]);

        $patient = User::where('role_id', 3)->where('id', '!=', $doctor->id)->inRandomOrder()->first()
            ?? User::factory()->create(['role_id' => 3]);

        return [
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence(12),
            'is_approved' => $this->faker->boolean(80), // 80% chance approved
        ];
    }
}
