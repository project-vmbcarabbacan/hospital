<?php

use App\Application\Utils\ExceptionConstants;
use App\Domain\Entities\PrescriptionEntity;
use App\Domain\Entities\PrescriptionItemEntity;
use App\Domain\Enums\RoleEnum;
use App\Domain\ValueObjects\IdObj;
use App\Infrastructure\Repositories\PrescriptionRepository;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\User;

beforeEach(function () {
    $this->repository = app(PrescriptionRepository::class);

    $this->role_doctor = RoleEnum::DOCTOR;
    $this->role_patient = RoleEnum::PATIENT;

    $this->doctor = User::factory()->create([
        'role_id' => $this->role_doctor->value
    ]);

    $this->patient = User::factory()->create([
        'role_id' => $this->role_patient->value
    ]);

    $this->appointment = Appointment::factory()->create([
        'doctor_id' => $this->doctor->id,
        'patient_id' => $this->patient->id,
        'date' => '2025-07-26',
        'appointment_time' => '09:00'
    ]);

    $this->prescription = Prescription::factory()->create([
        'doctor_id' => $this->doctor->id,
        'patient_id' => $this->patient->id,
        'appointment_id' => $this->appointment->id,
        'notes' => 'Cold and Fever'
    ]);

    $this->prescriptionItem = PrescriptionItem::factory()->create([
        'prescription_id' => $this->prescription->id,
        'medicine' => 'Paracetamol',
        'dosage' => '500 mg',
        'instructions' => '2x a day'
    ]);
});

it('finds prescription by id', function () {
    $result = $this->repository->getPrescriptionById(new IdObj($this->prescription->id));

    expect($result)->toBeInstanceOf(Prescription::class);
});

it('finds prescription by non-existent id', function () {
    $result = $this->repository->getPrescriptionById(new IdObj(9999));

    expect($result)->toBeEmpty();
});

it('finds prescription by patient id', function () {
    $result = $this->repository->getPrescriptionByPatientId(new IdObj($this->patient->id));

    expect($result->first())->toBeInstanceOf(Prescription::class);
});

it('finds prescription by non-existent patient id', function () {
    $result = $this->repository->getPrescriptionByPatientId(new IdObj(9999));

    expect($result)->toBeEmpty();
});

it('add new prescription', function () {

    $appointment = Appointment::factory()->create([
        'doctor_id' => $this->doctor->id,
        'patient_id' => $this->patient->id,
        'date' => '2025-07-30',
        'appointment_time' => '09:00'
    ]);

    $patient = User::factory()->create([
        'role_id' => $this->role_patient->value
    ]);

    $data = new PrescriptionEntity(
        doctor_id: new IdObj($this->doctor->id),
        patient_id: new IdObj($patient->id),
        appointment_id: new IdObj($appointment->id),
        notes: 'Broken Ankle Bone'
    );

    $result = $this->repository->addPrescription($data);

    expect($result)->toBeInstanceOf(Prescription::class)
        ->and($result->notes)->toBe('Broken Ankle Bone');
});

it('throw exception to a non-existent prescription id', function () {
    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::PRESCRIPTION_FOUND);

    $data = new PrescriptionEntity(
        doctor_id: new IdObj($this->doctor->id),
        patient_id: new IdObj($this->patient->id),
        appointment_id: new IdObj($this->appointment->id),
        notes: 'Broken Ankle Bone'
    );

    $this->repository->addPrescription($data);
});

it('update the prescription', function () {
    $data = new PrescriptionEntity(
        doctor_id: new IdObj($this->doctor->id),
        patient_id: new IdObj($this->patient->id),
        appointment_id: new IdObj($this->appointment->id),
        notes: 'Broken Ankle Bone'
    );

    $result = $this->repository->updatePrescription(new IdObj($this->prescription->id), $data);

    expect($result)->toBeInstanceOf(Prescription::class)
        ->and($result->notes)->toBe('Broken Ankle Bone');
});

it('throw an exception to update a non-existent prescription id', function () {
    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::PRESCRIPTION_NOT_FOUND);

    $data = new PrescriptionEntity(
        doctor_id: new IdObj($this->doctor->id),
        patient_id: new IdObj($this->patient->id),
        appointment_id: new IdObj($this->appointment->id),
        notes: 'Broken Ankle Bone'
    );

    $this->repository->updatePrescription(new IdObj(9999), $data);
});

it('find prescription item by id', function () {
    $result = $this->repository->getPrescriptionItemById(new IdObj($this->prescriptionItem->id));

    expect($result)->toBeInstanceOf(PrescriptionItem::class);
});

it('find a non-existent prescription item by id', function () {
    $result = $this->repository->getPrescriptionItemById(new IdObj(9999));

    expect($result)->toBeEmpty();
});

it('get all the patien prescription item by patient id', function () {

    PrescriptionItem::factory()->count(5)->create([
        'prescription_id' => $this->prescription->id
    ]);

    $result = $this->repository->getAllPrescriptionItemByPrescriptionId(new IdObj($this->prescription->id));

    expect($result)->toHaveCount(6);
    expect($result->first())->toBeInstanceOf(PrescriptionItem::class);
});

it('update the prescription item by id', function () {

    $data = new PrescriptionItemEntity(
        prescription_id: new IdObj($this->prescription->id),
        medicine: 'Lozartan',
        dosage: '100mg',
        instructions: 'Drink once a day'
    );

    $result = $this->repository->updatePrescriptionItem(new IdObj($this->prescriptionItem->id), $data);

    expect($result)->toBeInstanceOf(PrescriptionItem::class)
        ->and($result->medicine)->toBe('Lozartan')
        ->and($result->dosage)->toBe('100mg');
});

it('throw exception to update a non-existent prescription item id', function () {

    $data = new PrescriptionItemEntity(
        prescription_id: new IdObj($this->prescription->id),
        medicine: 'Lozartan',
        dosage: '100mg',
        instructions: 'Drink once a day'
    );

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::PRESCRIPTION_ITEM_FOUND);

    $result = $this->repository->updatePrescriptionItem(new IdObj(9999), $data);
});
