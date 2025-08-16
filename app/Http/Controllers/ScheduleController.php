<?php

namespace App\Http\Controllers;

use App\Application\Utils\ExceptionConstants;
use App\Application\Utils\SuccessConstants;
use App\Domain\Interfaces\Services\AppointmentServiceInterface;
use App\Domain\ValueObjects\DateObj;
use App\Domain\ValueObjects\IdObj;
use App\Http\Requests\Schedule\GetSchedule;
use App\Http\Resources\AppointmentResource;
use Exception;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __construct(
        protected AppointmentServiceInterface $appointmentService
    ) {}

    public function getAppointments(GetSchedule $request)
    {
        if (!$request->validated())
            return failed(ExceptionConstants::VALIDATION);

        try {
            $appointments = $this->appointmentService->getDoctorSchedulesByDate(
                new IdObj($request->user_id),
                new DateObj($request->date)
            );
            return success(SuccessConstants::APPOINTMENT, AppointmentResource::collection($appointments));
        } catch (Exception $e) {
            return failed(ExceptionConstants::DOCTOR_SCHEDULE_NOT_FOUND);
        }
    }
}
