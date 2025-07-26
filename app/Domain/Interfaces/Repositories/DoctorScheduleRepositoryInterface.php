<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Entities\DoctorScheduleEntity;
use App\Domain\Entities\DoctorScheduleExceptionEntity;
use App\Domain\ValueObjects\IdObj;

interface DoctorScheduleRepositoryInterface
{
    public function getDoctorByScheduleById(IdObj $id);
    public function getDoctorSchedulesByDoctorId(IdObj $doctor_id);
    public function addDoctorSchedule(DoctorScheduleEntity $data);
    public function updateDoctorSchedule(IdObj $id, DoctorScheduleEntity $data);
    public function getDoctorScheduleExceptionById(IdObj $id);
    public function getDoctorScheduleExceptionByDoctorId(IdObj $doctor_id);
    public function addDoctorScheduleException(DoctorScheduleExceptionEntity $data);
    public function updateDoctorScheduleException(IdObj $id, DoctorScheduleExceptionEntity $data);
}
