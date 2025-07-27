<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PrescriptionItem>
 */
class PrescriptionItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'prescription_id' => \App\Models\Prescription::factory(),
            'medicine' => $this->faker->randomElement([
                'Paracetamol',
                'Ibuprofen',
                'Amoxicillin',
                'Loratadine',
                'Metformin',
                'Omeprazole',
                'Ciprofloxacin',
                'Simvastatin',
                'Azithromycin',
                'Losartan'
            ]),
            'dosage' => $this->faker->randomElement([
                '500 mg',
                '250 mg',
                '1 tablet',
                '2 tablets',
                '5 ml',
                '10 ml'
            ]),
            'instructions' => $this->faker->randomElement([
                'Take after meals',
                'Before bedtime',
                'Twice daily',
                'Once a day',
                'Take on an empty stomach',
                'Every 8 hours'
            ]),
        ];
    }
}
