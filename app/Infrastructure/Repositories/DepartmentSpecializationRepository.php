<?php

namespace App\Infrastructure\Repositories;

use App\Models\Department;
use App\Models\Specialization;
use App\Domain\Interfaces\Repositories\DepartmentSpecializationRepositoryInterface;
use App\Application\Utils\ExceptionConstants;
use App\Domain\Entities\DepartmentEntity;
use App\Domain\Entities\SpecializationEntity;
use App\Domain\ValueObjects\IdObj;
use Exception;

class DepartmentSpecializationRepository implements DepartmentSpecializationRepositoryInterface {

    public function getAllDepartment() {
        return Department::get();
    }

    public function addDepartment(DepartmentEntity $data){
        try {
            $exist = $this->getDepartmentByName($data->name);
            if($exist)
                throw new Exception(ExceptionConstants::DEPARTMENT_EXIST);

            return Department::create([
                'name' => $data->name,
                'description' => $data->description
            ]);
        } catch(Exception $e) {
            throw new Exception(ExceptionConstants::DEPARTMENT_ADD);
        }
    }

    public function updateDepartment(IdObj $id, DepartmentEntity $data)
    {
        try {
            $department = $this->getDepartmentById($id);

            if (!$department) {
                throw new Exception(ExceptionConstants::DEPARTMENT_NOT_FOUND);
            }

            $updates = array_filter([
                'name' => $data->name,
                'description' => $data->description,
            ], fn($value) => !is_null($value));

            $department->update($updates);

            return $department;

        } catch (Exception $e) {
            throw new Exception(ExceptionConstants::DEPARTMENT_UPDATE);
        }
    }

    public function getAllSpecializationByDepartmentId(IdObj $department_id)
    {
        $department = $this->getDepartmentById($department_id);

        if (!$department) {
            throw new Exception(ExceptionConstants::DEPARTMENT_NOT_FOUND);
        }

        return Specialization::where('department_id', $department_id)->get();
    }

    public function addSpecialization(SpecializationEntity $data){
        try {
            $department = $this->getDepartmentById($data->department_id);
            if(!$department)
                throw new Exception(ExceptionConstants::DEPARTMENT_NOT_FOUND);

            $specialization = $this->getSpecializationByName($data->name);
            if($specialization)
                throw new Exception(ExceptionConstants::SPECIALIZATION_EXIST);

            return Specialization::create([
                'department_id' => $data->department_id->value(),
                'name' => $data->name,
                'description' => $data->description,
                'photo' => $data->photo
            ]);

        } catch(Exception $e) {
            throw new Exception(ExceptionConstants::SPECIALIZATION_ADD);
        }
    }

    public function updateSpecialization(IdObj $id, SpecializationEntity $data){
        try {
            $specialization = $this->getSpecializationById($id);
            if(!$specialization)
                throw new Exception('Specialization not found');

            $department = $this->getDepartmentById($data->department_id);
            if(!$department)
                throw new Exception(ExceptionConstants::DEPARTMENT_NOT_FOUND);

                $updates = array_filter([
                    'department_id' => $data->department_id->value(),
                    'name' => $data->name,
                    'description' => $data->description,
                    'photo' => $data->photo,
                ], fn($value) => !is_null($value));

            $specialization->update($updates);

            return $specialization;

        } catch(Exception $e) {
            throw new Exception(ExceptionConstants::SPECIALIZATION_UPDATE);
        }
    }


    public function getDepartmentById(IdObj $id) {
        return Department::find($id->value());
    }

    public function getSpecializationById(IdObj $id) {
        return Specialization::find($id->value());
    }

    protected function getDepartmentByName(string $name) {
        return Department::where('name', $name)->first();
    }

    protected function getSpecializationByName(string $name) {
        return Specialization::where('name', $name)->first();
    }



}
