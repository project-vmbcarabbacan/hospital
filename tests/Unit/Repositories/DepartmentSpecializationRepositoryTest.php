<?php

use App\Domain\Entities\DepartmentEntity;
use App\Domain\Entities\SpecializationEntity;
use App\Domain\ValueObjects\IdObj;
use App\Models\Department;
use App\Models\Specialization;
use App\Infrastructure\Repositories\DepartmentSpecializationRepository;
use App\Application\Utils\ExceptionConstants;

beforeEach(function () {
    $this->repository = app(DepartmentSpecializationRepository::class);
});

it('retrieves all departments', function () {
    Department::factory()->count(3)->create();
    $departments = $this->repository->getAllDepartment();

    expect($departments)->toHaveCount(3);
    expect($departments->first())->toBeInstanceOf(Department::class);
});



it('successfully adds a new department', function () {

    $data = new DepartmentEntity(
        name: 'IT',
        description: 'Handles technology',
        head_doctor_id: new IdObj(1),
        photo: 'default.png',
        working_hours: '8 AM to 5 PM'
    );

    $department = $this->repository->addDepartment($data);

    expect($department)->toBeInstanceOf(Department::class)
        ->and($department->name)->toBe('IT')
        ->and($department->description)->toBe('Handles technology');
});

it('throws exception when department already exists', function () {
    Department::create([
        'name' => 'HR',
        'description' => 'Handles people'
    ]);


    $data = new DepartmentEntity(
        name: 'HR',
        description: 'Another HR'
    );

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::DEPARTMENT_EXIST);

    $this->repository->addDepartment($data);
});

it('successfully update the department', function () {

    $data = new DepartmentEntity(
        name: 'IT',
        description: 'Handles technology'
    );

    $department = $this->repository->addDepartment($data);

    $department_id = new IdObj($department->id);

    $update = $this->repository->updateDepartment($department_id, new DepartmentEntity(
        name: 'Clinic',
        description: 'Health Care'
    ));

    expect($update)->toBeInstanceOf(Department::class)
        ->and($update->name)->toBe('Clinic')
        ->and($update->description)->toBe('Health Care');
});

it('throws exception when updating non-existent department', function () {

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::DEPARTMENT_NOT_FOUND);

    $department_id = new IdObj(9999);
    $this->repository->updateDepartment($department_id, new DepartmentEntity(
        name: 'Ghost Dept',
        description: 'Does not exist',
    ));
});


it('returns all specializations for a department', function () {
    $department = Department::factory()->create();

    Specialization::factory()->count(3)->create([
        'department_id' => $department->id,
    ]);

    $department_id = new IdObj($department->id);

    $result = $this->repository->getAllSpecializationByDepartmentId($department_id);

    expect($result)->toHaveCount(3);
    expect($result->first()->department_id)->toBe($department->id);
});

it('throws exception if department does not exist', function () {

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::DEPARTMENT_NOT_FOUND);

    $this->repository->getAllSpecializationByDepartmentId(new IdObj(9999));
});


it('successfully adds a specialization', function () {
    $department = Department::factory()->create();


    $data = new SpecializationEntity(
        name: 'Cardiology',
        department_id: new IdObj($department->id),
    );

    $specialization = $this->repository->addSpecialization($data);

    expect($specialization)->toBeInstanceOf(Specialization::class)
        ->and($specialization->name)->toBe('Cardiology')
        ->and($specialization->department_id)->toBe($department->id);
});

it('throws exception when department does not exist', function () {

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::DEPARTMENT_NOT_FOUND);

    $data = new SpecializationEntity(
        name: 'Neurology',
        department_id: new IdObj(999),
    );

    $this->repository->addSpecialization($data);
});

it('throws exception when specialization already exists', function () {
    $department = Department::factory()->create();

    Specialization::factory()->create([
        'name' => 'Pediatrics',
        'department_id' => $department->id,
    ]);

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::SPECIALIZATION_EXIST);

    $data = new SpecializationEntity(
        name: 'Pediatrics',
        department_id: new IdObj($department->id),
    );

    $this->repository->addSpecialization($data);
});

it('successfully updates a specialization', function () {
    $oldDepartment = Department::factory()->create();
    $newDepartment = Department::factory()->create();

    $specialization = Specialization::factory()->create([
        'name' => 'Surgery',
        'department_id' => $oldDepartment->id,
    ]);

    $specialization_id = new IdObj($specialization->id);

    $data = new SpecializationEntity(
        department_id: new IdObj($newDepartment->id),
        name: 'Advanced Surgery'
    );

    $updated = $this->repository->updateSpecialization($specialization_id, $data);

    expect($updated)->toBeInstanceOf(Specialization::class)
        ->and($updated->name)->toBe('Advanced Surgery')
        ->and($updated->department_id)->toBe($newDepartment->id);
});


it('throws exception if specialization is not found', function () {
    $department = Department::factory()->create();

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::SPECIALIZATION_NOT_FOUND);

    $data = new SpecializationEntity(
        department_id: new IdObj($department->id),
        name: 'Ghost Spec'
    );

    $this->repository->updateSpecialization(new IdObj(9999), $data);
});

it('throws exception if department is not found', function () {
    $specialization = Specialization::factory()->create();

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::DEPARTMENT_NOT_FOUND);

    $data = new SpecializationEntity(
        department_id: new IdObj(9999),
        name: 'Updated Name'
    );

    $this->repository->updateSpecialization(new IdObj($specialization->id), $data);
});


it('find department by id', function () {
    $department = Department::factory()->create([
        'name' => 'IT'
    ]);

    $department_id = new IdObj($department->id);

    $result = $this->repository->getDepartmentById($department_id);

    expect($result)->toBeInstanceOf(Department::class)
        ->and($result->name)->toBe('IT');
});

it('find specialization by id', function () {
    $department = Department::factory()->create();

    $specialization = Specialization::factory()->create([
        'name' => 'Surgery',
        'department_id' => $department->id,
    ]);

    $specialization_id = new IdObj($specialization->id);

    $result = $this->repository->getSpecializationById($specialization_id);

    expect($result)->toBeInstanceOf(Specialization::class)
        ->and($result->name)->toBe('Surgery');
});
