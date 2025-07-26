<?php

namespace App\Console\Commands;

use App\Models\Doctor\Schedule;
use App\Models\Doctor\ScheduleException;
use App\Models\Doctor\ScheduleInstance;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class GenerateDoctorSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-doctor-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate dated doctor schedule instances based on recurring schedule';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::transaction(function () {
            $daysAhead = 30;
            $startDate = Carbon::today();
            $endDate = $startDate->copy()->addDays($daysAhead);

            $this->info("Generating doctor schedules from $startDate to $endDate");

            $period = CarbonPeriod::create($startDate, $endDate);

            foreach ($period as $date) {
                $dayOfWeek = $date->format('l'); // 'Monday', 'Tuesday', etc.

                $schedules = Schedule::where('day_of_week', strtolower($dayOfWeek))
                    ->where('is_active', true)
                    ->get();

                foreach ($schedules as $schedule) {
                    // Check if date is marked as unavailable
                    $isBlocked = ScheduleException::where('user_id', $schedule->user_id)
                        ->whereDate('date', $date)
                        ->where('is_available', false)
                        ->exists();

                    if ($isBlocked) {
                        continue;
                    }

                    // Check if already exists
                    $exists = ScheduleInstance::where('user_id', $schedule->user_id)
                        ->whereDate('date', $date)
                        ->where('start_time', $schedule->start_time)
                        ->exists();

                    if (!$exists) {
                        ScheduleInstance::create([
                            'user_id' => $schedule->user_id,
                            'date' => $date->toDateString(),
                            'start_time' => $schedule->start_time,
                            'end_time' => $schedule->end_time,
                            'location' => $schedule->location,
                            'status' => 'available',
                            'source_schedule_id' => $schedule->id,
                        ]);
                    }
                }
            }
        });

        $this->info('Schedule instances generated successfully.');
    }
}
