<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prescription>
 */
class PrescriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doctor_id' => \App\Models\User::factory(),
            'patient_id' => \App\Models\User::factory(),
            'appointment_id' => \App\Models\Appointment::factory(),
            'notes' => $this->faker->sentence
        ];
    }
}
