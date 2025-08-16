<?php

namespace Database\Seeders;

use App\Models\Doctor\Schedule;
use App\Models\Doctor\ScheduleException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schedule::factory()->count(260)->create();
        ScheduleException::factory()->count(19)->create();
    }
}
