<?php

namespace App\Infrastructure\Repositories;

use App\Application\Utils\ExceptionConstants;
use App\Domain\Entities\AppointmentEntity;
use App\Domain\Entities\AppointmentFilterEntity;
use App\Domain\Interfaces\Repositories\AppointmentRepositoryInterface;
use App\Domain\ValueObjects\DateObj;
use App\Domain\ValueObjects\IdObj;
use App\Domain\ValueObjects\TimeOfDayObj;
use App\Models\Appointment;
use Exception;

class AppointmentRepository implements AppointmentRepositoryInterface
{

    public function addAppointment(AppointmentEntity $data)
    {
        try {
            $book = $this->checkIfPatientMadeAppointmentOfSameDay($data->patient_id, $data->date);
            if ($book)
                throw new Exception(ExceptionConstants::APPOINTMENT_BOOK);

            $booked = $this->checkIfAppointmentAlreadyBooked($data->date, $data->appointment_time);
            if ($booked)
                throw new Exception(ExceptionConstants::APPOINTMENT_BOOKED);

            return Appointment::create([
                'doctor_id' => $data->doctor_id->value(),
                'patient_id' => $data->patient_id->value(),
                'date' => $data->date->value(),
                'appointment_time' => $data->appointment_time->value(),
                'status' => $data->status,
                'notes' => $data->notes,
            ])->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateAppointment(IdObj $id, AppointmentEntity $data)
    {
        try {
            $appointment = $this->getAppointmentById($id);

            if (!$appointment)
                throw new Exception(ExceptionConstants::APPOINTMENT_NOT_FOUND);

            $book = $this->checkIfPatientMadeAppointmentOfSameDay($data->patient_id, $data->date);
            if ($book)
                throw new Exception(ExceptionConstants::APPOINTMENT_BOOK);

            $booked = $this->checkIfAppointmentAlreadyBooked($data->date, $data->appointment_time);
            if ($booked && !$data->patient_id->equals(new IdObj($booked->patient_id)))
                throw new Exception(ExceptionConstants::APPOINTMENT_BOOKED);

            $update = array_filter([
                'doctor_id' => $data->doctor_id->value(),
                'patient_id' => $data->patient_id->value(),
                'date' => $data->date->value(),
                'appointment_time' => $data->appointment_time->value(),
                'status' => $data->status,
                'notes' => $data->notes,
            ], fn($value) => !is_null($value));

            $appointment->update($update);

            return $appointment->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getAppointmentById(IdObj $id)
    {
        return Appointment::find($id->value());
    }

    public function getAllAppointments(AppointmentFilterEntity $data) {}

    protected function checkIfPatientMadeAppointmentOfSameDay(IdObj $patient_id, DateObj $date)
    {
        return Appointment::where('patient_id', $patient_id->value())
            ->whereDate('date', $date->value())
            ->exists();
    }

    protected function checkIfAppointmentAlreadyBooked(DateObj $date, TimeOfDayObj $appointment_time)
    {
        return Appointment::whereDate('date', $date->value())
            ->whereTime('appointment_time', $appointment_time->value())
            ->first();
    }
}
