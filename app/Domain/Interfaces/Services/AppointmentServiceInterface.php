<?php

namespace App\Domain\Interfaces\Services;

use App\Domain\ValueObjects\DateObj;
use App\Domain\ValueObjects\IdObj;

interface AppointmentServiceInterface
{
    public function getDoctorSchedulesByDate(IdObj $doctor_id, DateObj $date);
}
