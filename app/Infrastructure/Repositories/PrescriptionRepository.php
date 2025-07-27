<?php

namespace App\Infrastructure\Repositories;

use App\Application\Utils\ExceptionConstants;
use App\Domain\Entities\PrescriptionEntity;
use App\Domain\Entities\PrescriptionItemEntity;
use App\Domain\Interfaces\Repositories\PrescriptionRepositoryInterface;
use App\Domain\ValueObjects\IdObj;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Exception;

class PrescriptionRepository implements PrescriptionRepositoryInterface
{

    public function addPrescription(PrescriptionEntity $data)
    {
        try {
            $exist = $this->getPrescriptionByAppointmentAndPatientId($data->patient_id, $data->appointment_id);

            if ($exist)
                throw new Exception(ExceptionConstants::PRESCRIPTION_FOUND);

            return Prescription::create([
                'doctor_id' => $data->doctor_id->value(),
                'patient_id' => $data->patient_id->value(),
                'appointment_id' => $data->appointment_id->value(),
                'notes' => $data->notes
            ])->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updatePrescription(IdObj $id, PrescriptionEntity $data)
    {
        try {
            $prescription = $this->getPrescriptionById($id);

            if (!$prescription)
                throw new Exception(ExceptionConstants::PRESCRIPTION_NOT_FOUND);

            $data = array_filter([
                'doctor_id' => $data->doctor_id->value(),
                'patient_id' => $data->patient_id->value(),
                'appointment_id' => $data->appointment_id->value(),
                'notes' => $data->notes
            ], fn($value) => !is_null($value));

            $prescription->update($data);

            return $prescription->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function addPrescriptionItem(PrescriptionItemEntity $data)
    {
        try {
            return PrescriptionItem::create([
                'prescription_id' => $data->prescription_id->value(),
                'medicine' => $data->medicine,
                'dosage' => $data->dosage,
                'instructions' => $data->instructions
            ])->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updatePrescriptionItem(IdObj $id, PrescriptionItemEntity $data)
    {
        try {
            $prescriptionItem = $this->getPrescriptionItemById($id);

            if (!$prescriptionItem)
                throw new Exception(ExceptionConstants::PRESCRIPTION_ITEM_FOUND);

            $data = array_filter([
                'prescription_id' => $data->prescription_id->value(),
                'medicine' => $data->medicine,
                'dosage' => $data->dosage,
                'instructions' => $data->instructions
            ], fn($value) => !is_null($value));

            $prescriptionItem->update($data);

            return $prescriptionItem->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getPrescriptionItemById(IdObj $id)
    {
        return PrescriptionItem::find($id->value());
    }

    public function getAllPrescriptionItemByPrescriptionId(IdObj $prescription_id)
    {
        return PrescriptionItem::where('prescription_id', $prescription_id->value())->get();
    }

    public function getPrescriptionById(IdObj $id)
    {
        return Prescription::find($id->value());
    }

    public function getPrescriptionByPatientId(IdObj $patient_id)
    {
        return Prescription::where('patient_id', $patient_id->value())->get();
    }

    protected function getPrescriptionByAppointmentAndPatientId(IdObj $patient_id, IdObj $appointment_id)
    {
        return Prescription::where('patient_id', $patient_id->value())
            ->where('appointment_id', $appointment_id->value())
            ->first();
    }
}
