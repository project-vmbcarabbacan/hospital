<?php

use App\Application\Utils\ExceptionConstants;
use App\Domain\Entities\AppointmentEntity;
use App\Domain\Enums\RoleEnum;
use App\Domain\ValueObjects\DateObj;
use App\Domain\ValueObjects\IdObj;
use App\Domain\ValueObjects\TimeOfDayObj;
use App\Infrastructure\Repositories\AppointmentRepository;
use App\Models\Appointment;
use App\Models\User;

beforeEach(function () {
    $this->repository = app(AppointmentRepository::class);

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
});

it('find appointment by id', function () {
    $result = $this->repository->getAppointmentById(new IdObj($this->appointment->id));

    expect($result)->toBeInstanceOf(Appointment::class)
        ->and($result->doctor_id)->toBe($this->appointment->doctor_id)
        ->and($result->patient_id)->toBe($this->appointment->patient_id);
});

it('throw an exception to a non-existent id of appointment', function () {


    $result = $this->repository->getAppointmentById(new IdObj(999));

    expect($result)->toBeEmpty();
});

it('adds new appointment', function () {
    $add = new AppointmentEntity(
        doctor_id: new IdObj($this->doctor->id),
        patient_id: new IdObj($this->patient->id),
        date: new DateObj('2025-07-27'),
        appointment_time: new TimeOfDayObj('09:30'),
        status: 'pending',
        notes: 'Sinus problem'
    );

    $result = $this->repository->addAppointment($add);

    expect($result)->toBeInstanceOf(Appointment::class)
        ->and($result->doctor_id)->toBe($this->doctor->id)
        ->and($result->patient_id)->toBe($this->patient->id);
});

it('throw an exception while adding appointment with same patien at the same date', function () {
    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::APPOINTMENT_BOOK);

    $add = new AppointmentEntity(
        doctor_id: new IdObj($this->doctor->id),
        patient_id: new IdObj($this->patient->id),
        date: new DateObj('2025-07-26'),
        appointment_time: new TimeOfDayObj('09:00'),
        status: 'pending',
        notes: 'Sinus problem'
    );

    $this->repository->addAppointment($add);
});

it('thow an exception while adding if the booked date and time was already taken', function () {
    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::APPOINTMENT_BOOKED);

    $patient = User::factory()->create([
        'role_id' => $this->role_patient->value
    ]);

    $add = new AppointmentEntity(
        doctor_id: new IdObj($this->doctor->id),
        patient_id: new IdObj($patient->id),
        date: new DateObj('2025-07-26'),
        appointment_time: new TimeOfDayObj('09:00'),
        status: 'pending',
        notes: 'Sinus problem'
    );

    $this->repository->addAppointment($add);
});

it('update appointment of the patient', function () {

    $add = new AppointmentEntity(
        doctor_id: new IdObj($this->doctor->id),
        patient_id: new IdObj($this->patient->id),
        date: new DateObj('2025-07-27'),
        appointment_time: new TimeOfDayObj('10:00'),
        status: 'pending',
        notes: 'Sinus problem'
    );

    $result = $this->repository->updateAppointment(new IdObj($this->appointment->id), $add);

    expect($result)->toBeInstanceOf(Appointment::class)
        ->and($result->date)->toBe('2025-07-27')
        ->and($result->appointment_time)->toBe('10:00:00');
});

it('throw an exception while updating the appointment with non-existent id', function () {
    $add = new AppointmentEntity(
        doctor_id: new IdObj($this->doctor->id),
        patient_id: new IdObj($this->patient->id),
        date: new DateObj('2025-07-27'),
        appointment_time: new TimeOfDayObj('10:00'),
        status: 'pending',
        notes: 'Sinus problem'
    );

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::APPOINTMENT_NOT_FOUND);

    $this->repository->updateAppointment(new IdObj(999), $add);
});

it('throw an exception while updating the appointment with same day', function () {
    $appointment = Appointment::factory()->create([
        'doctor_id' => $this->doctor->id,
        'patient_id' => $this->patient->id,
        'date' => '2025-07-27',
        'appointment_time' => '09:00'
    ]);

    $add = new AppointmentEntity(
        doctor_id: new IdObj($this->doctor->id),
        patient_id: new IdObj($this->patient->id),
        date: new DateObj('2025-07-26'),
        appointment_time: new TimeOfDayObj('09:00'),
        status: 'pending',
        notes: 'Sinus problem'
    );

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::APPOINTMENT_BOOK);

    $this->repository->updateAppointment(new IdObj($appointment->id), $add);
});

it('throw an exception while updating the appointment with which already booked', function () {
    $user = User::factory()->create([
        'role_id' => $this->role_patient->value
    ]);

    $appointment = Appointment::factory()->create([
        'doctor_id' => $this->doctor->id,
        'patient_id' => $user->id,
        'date' => '2025-07-27',
        'appointment_time' => '09:00'
    ]);

    $add = new AppointmentEntity(
        doctor_id: new IdObj($this->doctor->id),
        patient_id: new IdObj($user->id),
        date: new DateObj('2025-07-26'),
        appointment_time: new TimeOfDayObj('09:00'),
        status: 'pending',
        notes: 'Sinus problem'
    );

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::APPOINTMENT_BOOKED);

    $this->repository->updateAppointment(new IdObj($appointment->id), $add);
});
