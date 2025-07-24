<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInformation>
 */
class UserInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\UserInformation::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'phone' => $this->faker->numerify('568#####'),
            'address' => $this->faker->address,
            'birthdate' => $this->faker->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'profile_photo' => 'https://i.pravatar.cc/300?img=' . $this->faker->numberBetween(1, 70),
        ];
    }
}
