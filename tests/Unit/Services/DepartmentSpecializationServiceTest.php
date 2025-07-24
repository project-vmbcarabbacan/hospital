<?php

use App\Application\DTOs\CreateDepartmentDto;
use App\Application\DTOs\CreateSpecializationDto;
use App\Application\Services\DepartmentSpecializationService;
use App\Domain\Entities\DepartmentEntity;
use App\Domain\Entities\SpecializationEntity;
use App\Domain\Interfaces\Repositories\DepartmentSpecializationRepositoryInterface;
use App\Domain\ValueObjects\IdObj;
use Illuminate\Support\Collection;

beforeEach(function () {
    $this->mockRepo = Mockery::mock(DepartmentSpecializationRepositoryInterface::class);
    $this->service = new DepartmentSpecializationService($this->mockRepo);
});


it('returns all departments as label-value', function () {
    $fakeDepartments = collect([
        (object)['id' => 1, 'name' => 'IT'],
        (object)['id' => 2, 'name' => 'HR'],
    ]);

    $this->mockRepo->shouldReceive('getAllDepartment')
        ->once()
        ->andReturn($fakeDepartments);

    // Assuming toLabelValue returns id+name
    $result = $this->service->getAllDepartments();

    expect($result)->toBeArray()
        ->and($result[0])->toHaveKeys(['label', 'value'])
        ->and($result[0]['label'])->toBe('IT')
        ->and($result[0]['value'])->toBe(1);
});

it('adds a new department', function () {
    $this->mockRepo->shouldReceive('addDepartment')
        ->once()
        ->with(Mockery::on(function ($arg) {
            return $arg instanceof DepartmentEntity
                && $arg->name === 'Finance'
                && $arg->description === 'Money stuff';
        }))
        ->andReturn((object)[
            'name' => 'Finance',
            'description' => 'Money stuff'
        ]);

    $serviceData = new CreateDepartmentDto(
        name: 'Finance',
        description: 'Money stuff'
    );

    $result = $this->service->addDepartment($serviceData);

    expect($result)->toBeObject()
        ->and($result->name)->toBe('Finance');
});


it('returns specializations by department ID in label-value format', function () {
    $departmentId = new IdObj(5);

    $fakeSpecializations = collect([
        (object) ['id' => 101, 'name' => 'Cardiology'],
        (object) ['id' => 102, 'name' => 'Neurology'],
    ]);

    $this->mockRepo->shouldReceive('getAllSpecializationByDepartmentId')
        ->once()
        ->with($departmentId)
        ->andReturn($fakeSpecializations);

    $result = $this->service->getAllSpecializationByDepartmentId($departmentId);

    expect($result)->toBeArray()
        ->and($result)->toHaveCount(2)
        ->and($result[0])->toMatchArray([
            'label' => 'Cardiology',
            'value' => 101,
        ])
        ->and($result[1]['label'])->toBe('Neurology');
});

it('throws an exception if repository fails during specialization fetch', function () {
    $this->mockRepo->shouldReceive('getAllSpecializationByDepartmentId')
        ->once()
        ->andThrow(new Exception('Repository error'));

    $this->expectException(Exception::class);
    $this->expectExceptionMessage('Repository error');

    $this->service->getAllSpecializationByDepartmentId(new IdObj(99));
});

it('updates specialization by delegating to repository', function () {
    $id = new IdObj(1);
    $departmentId = new IdObj(2);

    $dto = new CreateSpecializationDto(
        department_id: $departmentId,
        name: 'Updated Spec'
    );

    $this->mockRepo->shouldReceive('updateSpecialization')
        ->once()
        ->with($id, Mockery::on(function ($args) use ($departmentId) {
            return $args instanceof SpecializationEntity
                && $args->department_id->equals($departmentId)
                && $args->name === 'Updated Spec';
        }))
        ->andReturn((object) ['name' => 'Updated Spec']);

    $result = $this->service->updateSpecialization($id, $dto);

    expect($result)->toBeObject()
        ->and($result->name)->toBe('Updated Spec');
});
