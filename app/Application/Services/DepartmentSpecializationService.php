<?php

namespace App\Application\Services;

use App\Application\DTOs\CreateDepartmentDto;
use App\Application\DTOs\CreateSpecializationDto;
use App\Domain\Entities\DepartmentEntity;
use App\Domain\Entities\SpecializationEntity;
use App\Domain\Interfaces\Repositories\DepartmentSpecializationRepositoryInterface;
use App\Domain\Interfaces\Services\DepartmentSpecializationServiceInterface;
use App\Domain\ValueObjects\IdObj;
use Exception;

class DepartmentSpecializationService implements DepartmentSpecializationServiceInterface
{

    public function __construct(protected DepartmentSpecializationRepositoryInterface $repository) {}

    public function getAllDepartments()
    {
        $departments = $this->repository->getAllDepartment();
        return toLabelValue($departments);
    }

    public function getAllSpecializationByDepartmentId(IdObj $department_id)
    {
        $specializations = $this->repository->getAllSpecializationByDepartmentId($department_id);
        return toLabelValue($specializations);
    }

    public function addDepartment(CreateDepartmentDto $dto)
    {

        $department = new DepartmentEntity(...$dto->toArray());

        return $this->repository->addDepartment($department);
    }

    public function updateDepartment(IdObj $id, CreateDepartmentDto $dto)
    {
        $department = new DepartmentEntity(...$dto->toArray());

        return $this->repository->updateDepartment($id, $department);
    }

    public function addSpecialization(CreateSpecializationDto $dto)
    {
        $create = new SpecializationEntity(...$dto->toArray());
        return $this->repository->addSpecialization($create);
    }

    public function updateSpecialization(IdObj $id, CreateSpecializationDto $dto)
    {
        $update = new SpecializationEntity(...$dto->toArray());
        return $this->repository->updateSpecialization($id, $update);
    }
}
