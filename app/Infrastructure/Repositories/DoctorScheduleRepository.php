<?php

namespace App\Infrastructure\Repositories;

use App\Application\Utils\ExceptionConstants;
use App\Domain\Entities\DoctorScheduleEntity;
use App\Domain\Entities\DoctorScheduleExceptionEntity;
use App\Domain\Interfaces\Repositories\DoctorScheduleRepositoryInterface;
use App\Domain\ValueObjects\DateObj;
use App\Models\Doctor\Schedule;
use App\Domain\ValueObjects\IdObj;
use App\Domain\ValueObjects\DayOfWeekObj;
use App\Domain\ValueObjects\TimeOfDayObj;
use App\Models\Doctor\ScheduleException;
use Exception;

class DoctorScheduleRepository implements DoctorScheduleRepositoryInterface
{

    public function getDoctorSchedulesById(IdObj $id)
    {
        return Schedule::find($id->value());
    }

    public function getDoctorSchedulesByDoctorId(IdObj $doctor_id)
    {
        return Schedule::where('user_id', $doctor_id->value())->get();
    }

    public function getDoctorScheduleExceptionById(IdObj $id)
    {
        return ScheduleException::find($id->value());
    }

    public function getDoctorScheduleExceptionByDoctorId(IdObj $doctor_id)
    {
        return ScheduleException::where('user_id', $doctor_id->value())->get();
    }

    public function addDoctorSchedule(DoctorScheduleEntity $data)
    {
        try {
            $exist = $this->checkIfScheduleHasConflict($data->user_id, $data->day_of_week, $data->start_time, $data->end_time);

            if ($exist)
                throw new Exception(ExceptionConstants::DOCTOR_SCHEDULE_EXIST);

            $data = array_filter([
                "user_id" => $data->user_id->value(),
                "day_of_week" => $data->day_of_week->value(),
                "start_time" => $data->start_time->compare($data->end_time),
                "end_time" => $data->start_time->compare($data->end_time, false),
                "location" => $data->location,
                "is_active" => $data->is_active,
            ], fn($value) => !is_null($value));

            $schedule = Schedule::create($data);

            return $schedule->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateDoctorSchedule(IdObj $id, DoctorScheduleEntity $data)
    {
        try {
            $schedule = $this->getDoctorByScheduleById($id);

            if (!$schedule)
                throw new Exception(ExceptionConstants::DOCTOR_SCHEDULE_NOT_FOUND);

            if ($this->checkIfScheduleHasConflict($data->user_id, $data->day_of_week, $data->start_time, $data->end_time))
                throw new Exception(ExceptionConstants::DOCTOR_SCHEDULE_EXIST);

            $data = array_filter([
                "user_id" => $data->user_id->value(),
                "day_of_week" => $data->day_of_week->value(),
                "start_time" => $data->start_time->compare($data->end_time),
                "end_time" => $data->start_time->compare($data->end_time, false),
                "location" => $data->location,
                "is_active" => $data->is_active,
            ], fn($value) => !is_null($value));

            $schedule->update($data);

            return $schedule->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function addDoctorScheduleException(DoctorScheduleExceptionEntity $data)
    {
        try {
            $exception = $this->getDoctorExceptionDate($data->user_id, $data->date);

            if ($exception)
                throw new Exception(ExceptionConstants::DOCTOR_SCHEDULE_EXCEPTION_EXIST);

            $data = array_filter([
                "user_id" => $data->user_id->value(),
                "date" => $data->date->value(),
                "is_available" => $data->is_available,
                "notes" => $data->notes,
            ], fn($value) => !is_null($value));

            $schedule = ScheduleException::create($data);

            return $schedule->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateDoctorScheduleException(IdObj $id, DoctorScheduleExceptionEntity $data)
    {
        try {
            $exist = $this->getDoctorScheduleExceptionById($id);

            if (!$exist)
                throw new Exception(ExceptionConstants::DOCTOR_SCHEDULE_EXCEPTION_NOT_FOUND);

            $exception = $this->getDoctorExceptionDate($data->user_id, $data->date, $id);

            if ($exception)
                throw new Exception(ExceptionConstants::DOCTOR_SCHEDULE_EXCEPTION_EXIST);

            $data = array_filter([
                "user_id" => $data->user_id->value(),
                "date" => $data->date->value(),
                "is_available" => $data->is_available,
                "notes" => $data->notes,
            ], fn($value) => !is_null($value));

            $exist->update($data);

            return $exist->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function getDoctorByScheduleById(IdObj $id)
    {
        return Schedule::find($id->value());
    }

    protected function checkIfScheduleHasConflict(IdObj $doctor_id, DayOfWeekObj $day_of_week, TimeOfDayObj $start_time, TimeOfDayObj $end_time)
    {
        return Schedule::where('day_of_week', $day_of_week->value())
            ->where('user_id', $doctor_id->value())
            ->where(function ($query) use ($end_time, $start_time) {
                $query->where(function ($q) use ($end_time, $start_time) {
                    $q->where('start_time', '<', (string) $end_time)
                        ->where('end_time', '>', (string) $start_time);
                });
            })->exists();
    }

    protected function getDoctorExceptionDate(IdObj $doctor_id, DateObj $date, ?IdObj $id = null)
    {
        $exception =  ScheduleException::where('user_id', $doctor_id)
            ->where('date', $date);

        if (!is_null($id))
            $exception = $exception->where('id', '<>', $id);

        return $exception->first();
    }
}
