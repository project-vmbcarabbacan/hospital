<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'appointment_id'   => $this->id,
            'type'             => $this->service?->appointmentType?->name,
            'service'          => $this->service?->name,
            'doctor'           => $this->doctor?->name,
            'doctor_id'        => $this->doctor_id,
            'patient'          => $this->patient?->name,
            'patient_id'       => $this->patient_id,
            'date'             => $this->date,
            'appointment_time' => $this->appointment_time,
            'status'           => $this->status,
            'notes'            => $this->notes,
        ];
    }
}
