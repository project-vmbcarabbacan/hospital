<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Entities\PrescriptionEntity;
use App\Domain\Entities\PrescriptionItemEntity;
use App\Domain\ValueObjects\IdObj;

interface PrescriptionRepositoryInterface
{
    public function addPrescription(PrescriptionEntity $data);
    public function updatePrescription(IdObj $id, PrescriptionEntity $data);
    public function getPrescriptionById(IdObj $id);
    public function getPrescriptionByPatientId(IdObj $patient_id);
    public function addPrescriptionItem(PrescriptionItemEntity $data);
    public function updatePrescriptionItem(IdObj $id, PrescriptionItemEntity $data);
    public function getPrescriptionItemById(IdObj $id);
    public function getAllPrescriptionItemByPrescriptionId(IdObj $prescription_id);
}
