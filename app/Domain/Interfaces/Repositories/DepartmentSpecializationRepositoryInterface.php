<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Entities\DepartmentEntity;
use App\Domain\Entities\SpecializationEntity;
use App\Domain\ValueObjects\IdObj;

interface DepartmentSpecializationRepositoryInterface
{
    public function getDepartmentById(IdObj $id);
    public function getAllDepartment();
    public function addDepartment(DepartmentEntity $data);
    public function updateDepartment(IdObj $id, DepartmentEntity $data);
    public function getAllSpecializationByDepartmentId(IdObj $department_id);
    public function getSpecializationById(IdObj $department_id);
    public function addSpecialization(SpecializationEntity $data);
    public function updateSpecialization(IdObj $id, SpecializationEntity $data);
}
