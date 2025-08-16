<?php

namespace Database\Seeders;

use App\Models\AppointmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $types = [
            'Consultation' => [
                [
                    'sku' => 'sapcon-00001',
                    'name' => 'General Physician',
                    'price' => '35',
                ],
                [
                    'sku' => 'sapcon-00002',
                    'name' => 'Specialist Consultation',
                    'price' => '40',
                ],
                [
                    'sku' => 'sapcon-00003',
                    'name' => 'Second Opinion',
                    'price' => '65',
                ],
            ],
            'Follow-Up Appointment' => [
                [
                    'sku' => 'sapfua-00001',
                    'name' => 'Post-treatment review',
                    'price' => '25',
                ],
                [
                    'sku' => 'sapfua-00002',
                    'name' => 'Post-surgery checkup',
                    'price' => '50',
                ],
                [
                    'sku' => 'sapfua-00003',
                    'name' => 'Chronic condition monitoring',
                    'price' => '70',
                ],
            ],
            'Diagnostic Services' => [
                [
                    'sku' => 'sapdis-00001',
                    'name' => 'Blood Tests',
                    'price' => '45',
                ],
                [
                    'sku' => 'sapdis-00002',
                    'name' => 'Imaging (X-ray, MRI, CT Scan)',
                    'price' => '55',
                ],
                [
                    'sku' => 'sapdis-00003',
                    'name' => 'ECG/Echo',
                    'price' => '85',
                ],
                [
                    'sku' => 'sapdis-00004',
                    'name' => 'Endoscopy/Colonoscopy',
                    'price' => '90',
                ],
            ],
            'Therapy & Treatment Services' => [
                [
                    'sku' => 'saptts-00001',
                    'name' => 'Physical Therapy',
                    'price' => '40',
                ],
                [
                    'sku' => 'saptts-00002',
                    'name' => 'Chemotherapy/Radiation',
                    'price' => '60',
                ],
                [
                    'sku' => 'saptts-00003',
                    'name' => 'Dialysis',
                    'price' => '55',
                ],
                [
                    'sku' => 'saptts-00004',
                    'name' => 'Mental Health Counseling/Psychiatry',
                    'price' => '25',
                ],
            ],
            'Surgical Appointment' => [
                [
                    'sku' => 'sapsua-00001',
                    'name' => 'Pre-Surgery Assessment',
                    'price' => '40',
                ],
                [
                    'sku' => 'sapsua-00002',
                    'name' => 'Surgery Scheduling',
                    'price' => '65',
                ],
                [
                    'sku' => 'sapsua-00003',
                    'name' => 'Post-Surgical Follow-up',
                    'price' => '65',
                ],
            ],
            'Emergency Services' => [
                [
                    'sku' => 'sapems-00001',
                    'name' => 'Trauma care',
                    'price' => '40',
                ],
                [
                    'sku' => 'sapems-00002',
                    'name' => 'Urgent consultation',
                    'price' => '65',
                ],
            ],
            'Vaccination or Immunization' => [
                [
                    'sku' => 'sapvoi-00001',
                    'name' => 'Routine vaccinations',
                    'price' => '30',
                ],
                [
                    'sku' => 'sapvoi-00002',
                    'name' => 'Travel-related vaccines',
                    'price' => '35',
                ],
            ],
            'Health Check-up Packages' => [
                [
                    'sku' => 'saphcp-00001',
                    'name' => 'Annual Health Check',
                    'price' => '75',
                ],
                [
                    'sku' => 'saphcp-00002',
                    'name' => 'Executive Health Check',
                    'price' => '100',
                ],
                [
                    'sku' => 'saphcp-00003',
                    'name' => 'Pre-employment Medical Exam',
                    'price' => '20',
                ],
            ],
            'Maternity & Pediatric Services' => [
                [
                    'sku' => 'sapmps-00001',
                    'name' => 'Antenatal checkups',
                    'price' => '50',
                ],
                [
                    'sku' => 'sapmps-00002',
                    'name' => 'Pediatrician consultation',
                    'price' => '65',
                ],
                [
                    'sku' => 'sapmps-00003',
                    'name' => 'Ultrasound/Scans',
                    'price' => '65',
                ],
            ],
            'Telemedicine Appointments' => [
                [
                    'sku' => 'saptea-00001',
                    'name' => 'Virtual Consultation',
                    'price' => '65',
                ],
                [
                    'sku' => 'saptea-00002',
                    'name' => 'Remote Follow-up',
                    'price' => '65',
                ],
            ],
        ];

        foreach ($types as $type => $value) {
            $appointment = AppointmentType::create([
                'name' => $type
            ]);

            $servicesWithExtras = array_map(function ($service) use ($faker) {
                return array_merge($service, [
                    'status' => $faker->boolean(90), // 90% chance of true (active)
                    'photo' => $faker->imageUrl(640, 480, 'medical', true, 'service'),
                ]);
            }, $value);

            $appointment->services()->createMany($servicesWithExtras);
        }
    }
}
