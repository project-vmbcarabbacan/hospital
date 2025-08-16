<?php

namespace App\Application\Services;

use App\Domain\Interfaces\Repositories\AppointmentRepositoryInterface;
use App\Domain\Interfaces\Services\AppointmentServiceInterface;
use App\Domain\ValueObjects\DateObj;
use App\Domain\ValueObjects\IdObj;

class AppointmentService implements AppointmentServiceInterface
{

    public function __construct(
        protected AppointmentRepositoryInterface $appointmentRepository,
    ) {}

    public function getDoctorSchedulesByDate(IdObj $doctor_id, DateObj $date)
    {
        return $this->appointmentRepository->getAppointByDoctorIdAndDate($doctor_id, $date);
    }
}
