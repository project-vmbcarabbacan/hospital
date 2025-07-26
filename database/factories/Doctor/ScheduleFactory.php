<?php

namespace Database\Factories\Doctor;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor\\Schedule>
 */
class ScheduleFactory extends Factory
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
            'day_of_week' => $this->faker->randomElement(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']),
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time(),
            'location' => $this->faker->randomElement(['room', 'clinic', 'hospital']),
            'is_active' => $this->faker->boolean()
        ];
    }
}
