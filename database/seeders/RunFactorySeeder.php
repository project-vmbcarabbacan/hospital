<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RunFactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory(50)->create();
        \App\Models\UserInformation::factory(50)->create();
        \App\Models\Achievement::factory(50)->create();
        \App\Models\DoctorSpecialization::factory(70)->create();
        \App\Models\Distributor::factory(25)->create();
        \App\Models\Brand::factory(100)->create();
        \App\Models\Product::factory(180)->create();
        \App\Models\Service::factory(60)->create();
        \App\Models\Doctor\Schedule::factory(500)->create();
        \App\Models\Doctor\ScheduleException::factory(50)->create();
    }
}
