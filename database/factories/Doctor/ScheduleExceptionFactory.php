<?php

namespace Database\Factories\Doctor;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor\ScheduleException>
 */
class ScheduleExceptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'date' => $this->faker->date('Y-m-d'),
            'is_available' => $this->faker->boolean(),
            'notes' => $this->faker->paragraph,
        ];
    }
}
