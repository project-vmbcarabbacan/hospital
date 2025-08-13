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
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'title' => $this->faker->title(),
            'phone' => $this->faker->numerify('568#####'),
            'address' => $this->faker->address,
            'license_number' => $this->faker->numerify('789-###-##-#'),
            'license_expiry' => $this->faker->dateTimeBetween('+2 years', '+5 years')->format('Y-m-d'),
            'birthdate' => $this->faker->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
            'hired_date' => $this->faker->dateTimeBetween('-10 years', '-1 years')->format('Y-m-d'),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'bio' => $this->faker->word(),
            'experience_years' => $this->faker->randomElement([1, 10]),
            'is_visible' => $this->faker->boolean(),
            'days_of_working' => $this->faker->randomElement([
                'Monday to Friday',
                'Monday to Saturday',
                'Weekends Only',
                'Flexible Schedule',
            ]),
            'work_timing' => $this->faker->randomElement([
                '9am - 5pm',
                '10am - 6pm',
                '8am - 4pm',
                'Shift-based',
                'Flexible Hours',
            ]),
            'occupation_type' => $this->faker->randomElement([
                'Full-time',
                'Part-time',
                'Freelance',
                'Internship',
                'Contract',
                'Remote',
            ]),
            'profile_photo' => 'https://i.pravatar.cc/300?img=' . $this->faker->numberBetween(1, 70),
        ];
    }
}
