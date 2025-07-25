<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->jobTitle,
            'description' => $this->faker->sentence,
            'head_doctor_id' => \App\Models\User::factory(),
            'working_hours' => '8 AM to 5 PM',
            'photo' => 'https://i.pravatar.cc/300?img=' . $this->faker->numberBetween(1, 70)
        ];
    }
}
