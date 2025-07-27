<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Entities\AppointmentEntity;
use App\Domain\Entities\AppointmentFilterEntity;
use App\Domain\ValueObjects\IdObj;

interface AppointmentRepositoryInterface
{
    public function addAppointment(AppointmentEntity $data);
    public function updateAppointment(IdObj $id, AppointmentEntity $data);
    public function getAppointmentById(IdObj $id);
    public function getAllAppointments(AppointmentFilterEntity $data);
}
