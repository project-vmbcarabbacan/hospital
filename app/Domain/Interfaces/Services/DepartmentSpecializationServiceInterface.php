<?php

namespace App\Domain\Interfaces\Services;

use App\Application\DTOs\CreateDepartmentDto;
use App\Application\DTOs\CreateSpecializationDto;
use App\Domain\ValueObjects\IdObj;

interface DepartmentSpecializationServiceInterface {

    public function getAllDepartments();
    public function getAllSpecializationByDepartmentId(IdObj $department_id);
    public function addDepartment(CreateDepartmentDto $dto);
    public function updateDepartment(IdObj $id, CreateDepartmentDto $dto);
    public function addSpecialization(CreateSpecializationDto $dto);
    public function updateSpecialization(IdObj $id, CreateSpecializationDto $dto);
}
