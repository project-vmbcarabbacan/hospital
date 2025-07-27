<?php

use App\Application\Utils\ExceptionConstants;
use App\Domain\Entities\RatingEntity;
use App\Domain\Enums\RoleEnum;
use App\Domain\ValueObjects\IdObj;
use App\Infrastructure\Repositories\RatingRepository;
use App\Models\Doctor\Rating;
use App\Models\User;

beforeEach(function () {

    $this->repository = app(RatingRepository::class);

    $this->role_doctor = RoleEnum::DOCTOR;
    $this->role_patient = RoleEnum::PATIENT;

    $this->doctor = User::factory()->create([
        'role_id' => $this->role_doctor->value
    ]);

    $this->patient = User::factory()->create([
        'role_id' => $this->role_patient->value
    ]);

    $this->rating = Rating::factory()->create([
        'doctor_id' => $this->doctor->id,
        'patient_id' => $this->patient->id,
        'rating' => 4,
        'is_approved' => true
    ]);
});

it('find rating by id', function () {
    $result = $this->repository->getRatingById(new IdObj($this->rating->id));

    expect($result)->toBeInstanceOf(Rating::class);
});


it('find rating with non-existent id', function () {
    $result = $this->repository->getRatingById(new IdObj(9999));

    expect($result)->toBeEmpty();
});

it('add new rating', function () {
    $data = new RatingEntity(
        doctor_id: new IdObj($this->doctor->id),
        patient_id: new IdObj($this->patient->id),
        rating: 5,
        comment: 'awesome',
        is_approved: true
    );

    $result = $this->repository->addRating($data);

    expect($result)->toBeInstanceOf(Rating::class)
        ->and($result->rating)->toBe(5);
});

it('get the average by doctor id', function () {
    Rating::factory()->create([
        'doctor_id' => $this->doctor->id,
        'patient_id' => $this->patient->id,
        'rating' => 5,
        'is_approved' => true
    ]);

    $result = $this->repository->getAverageByDoctorId(new IdObj($this->doctor->id));

    expect($result)->toBe(4.5);
});

it('update the rating by id', function () {
    $data = new RatingEntity(
        doctor_id: new IdObj($this->doctor->id),
        patient_id: new IdObj($this->patient->id),
        rating: 5,
        comment: 'awesome',
        is_approved: true
    );

    $result = $this->repository->updateRating(new IdObj($this->rating->id), $data);

    expect($result)->toBeInstanceOf(Rating::class)
        ->and($result->rating)->toBe(5);
});

it('update the rating with a non-existent id', function () {
    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::RATING_NOT_FOUND);

    $data = new RatingEntity(
        doctor_id: new IdObj($this->doctor->id),
        patient_id: new IdObj($this->patient->id),
        rating: 5,
        comment: 'awesome',
        is_approved: true
    );

    $result = $this->repository->updateRating(new IdObj(9999), $data);
});
