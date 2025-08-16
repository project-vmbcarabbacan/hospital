<?php

namespace Database\Factories\Doctor;

use App\Models\User;
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
        // Generate a random start datetime between 8 AM and 5 PM
        $start = $this->faker->dateTimeBetween('08:00:00', '17:00:00');

        // Round start time down to the nearest 30 minutes
        $startMinutes = (int) $start->format('i');
        $roundedMinutes = $startMinutes < 30 ? 0 : 30;
        $start->setTime(
            (int) $start->format('H'),
            $roundedMinutes,
            0
        );

        // Generate end time by adding 30-minute increments (1 to 16 increments => 30 mins to 8 hours)
        $increments = rand(1, 16);
        $end = (clone $start)->modify('+' . ($increments * 30) . ' minutes');

        return [
            'user_id' => function () {
                return User::where('role_id', 3)->inRandomOrder()->value('id');
            },
            'day_of_week' => $this->faker->randomElement(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']),
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),
            'location' => $this->faker->randomElement(['room', 'clinic', 'hospital']),
            'is_active' => $this->faker->boolean()
        ];
    }
}
