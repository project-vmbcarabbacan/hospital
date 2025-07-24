<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Distributor>
 */
class DistributorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'contact' => $this->faker->numerify('568#####'),
            'phone' => $this->faker->numerify('568#####'),
            'address' => $this->faker->address,
            'photo' => 'https://i.pravatar.cc/300?img=' . $this->faker->numberBetween(1, 70)
        ];
    }
}
