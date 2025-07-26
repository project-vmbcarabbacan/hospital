<?php

use App\Domain\Entities\AchievementEntity;
use App\Domain\Entities\DoctorSpecializationEntity;
use App\Domain\Enums\RoleEnum;
use App\Domain\ValueObjects\IdObj;
use App\Infrastructure\Repositories\UserSpecializationAchievementRepository;
use App\Models\Department;
use App\Models\Achievement;
use App\Models\DoctorSpecialization;
use App\Models\Specialization;
use App\Models\User;

beforeEach(function () {
    $this->repository = app(UserSpecializationAchievementRepository::class);
});

it('add doctor specialization', function () {
    $role = RoleEnum::DOCTOR;
    $user = User::factory()->create([
        'role_id' => $role->value
    ]);
    Department::factory()->create();
    $specialization = Specialization::factory()->create();

    $result = $this->repository->doctorSpecialization(new IdObj($user->id), new IdObj($specialization->id));

    expect($result)->toBeInstanceOf(DoctorSpecialization::class)
        ->and($result->user_id)->toBe($user->id)
        ->and($result->specialization_id)->toBe($specialization->id);
});

it('add doctor achievement', function () {
    $role = RoleEnum::DOCTOR;
    $user = User::factory()->create([
        'role_id' => $role->value
    ]);

    $data = new AchievementEntity(
        user_id: new IdObj($user->id),
        title: "Outstanding Team Contributor",
        description: 'Blah BLah Blah',
        year_awarded: '2022'
    );

    $result = $this->repository->addAchievement($data);

    expect($result)->toBeInstanceOf(Achievement::class)
        ->and($result->title)->toBe("Outstanding Team Contributor")
        ->and($result->year_awarded)->toBe('2022');
});

it('update doctor achievement', function () {
    $role = RoleEnum::DOCTOR;
    $user = User::factory()->create([
        'role_id' => $role->value
    ]);

    $achievement = Achievement::factory()->create([
        'user_id' => $user->id
    ]);

    $data = new AchievementEntity(
        user_id: new IdObj($user->id),
        title: "Outstanding Team Contributor",
        description: 'Blah BLah Blah',
        year_awarded: '2022'
    );

    $result = $this->repository->updateAchievement(new IdObj($achievement->id), $data);

    expect($result)->toBeInstanceOf(Achievement::class)
        ->and($result->title)->toBe("Outstanding Team Contributor")
        ->and($result->year_awarded)->toBe('2022');
});

it('find achievement by id', function () {
    $role = RoleEnum::DOCTOR;
    $user = User::factory()->create([
        'role_id' => $role->value
    ]);

    $achievement = Achievement::factory()->create([
        'user_id' => $user->id
    ]);

    $result = $this->repository->getAchievementById(new IdObj($achievement->id));

    expect($result)->toBeInstanceOf(Achievement::class)
        ->and($result)->not->toBeNull();
});
