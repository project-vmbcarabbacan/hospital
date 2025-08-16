<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('08:00:00', '17:00:00');

        // Round start time down to the nearest 30 minutes
        $startMinutes = (int) $start->format('i');
        $roundedMinutes = $startMinutes < 30 ? 0 : 30;
        $start->setTime(
            (int) $start->format('H'),
            $roundedMinutes,
            0
        );

        return [
            'doctor_id' => function () {
                return User::where('role_id', 3)->inRandomOrder()->value('id');
            },
            'patient_id' => function () {
                return User::where('role_id', 11)->inRandomOrder()->value('id');
            },
            'service_id' => Service::inRandomOrder()->value('id'),
            'date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'appointment_time' => $start->format('H:i:s'),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            'notes' => $this->faker->paragraph,
        ];
    }
}
