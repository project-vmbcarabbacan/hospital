<?php

use App\Application\Utils\ExceptionConstants;
use App\Domain\Entities\DoctorScheduleEntity;
use App\Domain\Entities\DoctorScheduleExceptionEntity;
use App\Domain\ValueObjects\DateObj;
use App\Domain\ValueObjects\DayOfWeekObj;
use App\Domain\ValueObjects\IdObj;
use App\Domain\ValueObjects\TimeOfDayObj;
use App\Infrastructure\Repositories\DoctorScheduleRepository;
use App\Models\Doctor\Schedule;
use App\Models\Doctor\ScheduleException;
use App\Models\User;

beforeEach(function () {
    $this->repository = app(DoctorScheduleRepository::class);
});

it('add doctor schedule', function () {
    $user = User::factory()->create();

    $data = new DoctorScheduleEntity(
        user_id: new IdObj($user->id),
        day_of_week: new DayOfWeekObj('monday'),
        start_time: new TimeOfDayObj('09:00'),
        end_time: new TimeOfDayObj('10:00'),
        location: 'clinic',
        is_active: true
    );

    $result = $this->repository->addDoctorSchedule($data);

    expect($result)->toBeInstanceOf(Schedule::class)
        ->and($result->day_of_week)->toBe('monday')
        ->and($result->start_time)->toBe('09:00:00')
        ->and($result->end_time)->toBe('10:00:00');
});

it('add doctor with start time is after end time schedule', function () {
    $user = User::factory()->create();

    $data = new DoctorScheduleEntity(
        user_id: new IdObj($user->id),
        day_of_week: new DayOfWeekObj('monday'),
        start_time: new TimeOfDayObj('11:00'),
        end_time: new TimeOfDayObj('10:00'),
        location: 'clinic',
        is_active: true
    );

    $result = $this->repository->addDoctorSchedule($data);

    expect($result)->toBeInstanceOf(Schedule::class)
        ->and($result->day_of_week)->toBe('monday')
        ->and($result->start_time)->toBe('10:00:00')
        ->and($result->end_time)->toBe('11:00:00');
});

it('fetch schedule by id', function () {
    $user = User::factory()->create();

    $schedule = Schedule::factory()->create([
        "user_id" => $user->id
    ]);

    $result = $this->repository->getDoctorByScheduleById(new IdObj($schedule->id));

    expect($result)->not->toBeEmpty()
        ->toBeInstanceOf(Schedule::class);
});

it('throws exception when updating non-existent schedule', function () {
    User::factory()->create();
    Schedule::factory()->create();

    $result = $this->repository->getDoctorByScheduleById(new IdObj(9999));

    expect($result)->toBeEmpty();
});

it('update doctor schedule', function () {
    $user = User::factory()->create();
    $schedule = Schedule::factory()->create();

    $data = new DoctorScheduleEntity(
        user_id: new IdObj($user->id),
        day_of_week: new DayOfWeekObj('monday'),
        start_time: new TimeOfDayObj('09:00'),
        end_time: new TimeOfDayObj('10:00'),
        location: 'clinic',
        is_active: true
    );

    $result = $this->repository->updateDoctorSchedule(new IdObj($schedule->id), $data);

    expect($result)->toBeInstanceOf(Schedule::class)
        ->and($result->day_of_week)->toBe('monday')
        ->and($result->start_time)->toBe('09:00:00')
        ->and($result->end_time)->toBe('10:00:00');
});

it('throws exception when adding non-existent schedule', function () {
    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::DOCTOR_SCHEDULE_NOT_FOUND);

    $data = new DoctorScheduleEntity(
        user_id: new IdObj(99),
        day_of_week: new DayOfWeekObj('monday'),
        start_time: new TimeOfDayObj('09:00'),
        end_time: new TimeOfDayObj('10:00'),
        location: 'clinic',
        is_active: true
    );

    $this->repository->updateDoctorSchedule(new IdObj(9999), $data);
});

it('throws exception when adding conflict time of same doctor', function () {
    $user = User::factory()->create();
    Schedule::factory()->create([
        "user_id" => $user->id,
        "day_of_week" => 'monday',
        "start_time" => '09:00',
        "end_time" => '10:00',
    ]);

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::DOCTOR_SCHEDULE_EXIST);

    $data = new DoctorScheduleEntity(
        user_id: new IdObj($user->id),
        day_of_week: new DayOfWeekObj('monday'),
        start_time: new TimeOfDayObj('09:00'),
        end_time: new TimeOfDayObj('10:00'),
        location: 'clinic',
        is_active: true
    );

    $this->repository->addDoctorSchedule($data);
});

it('fetch schedule exception by id', function () {
    $exception = ScheduleException::factory()->create();

    $result = $this->repository->getDoctorScheduleExceptionById(new IdObj($exception->id));

    expect($result)->toBeInstanceOf(ScheduleException::class)
        ->and($result->id)->toBe($exception->id);
});

it('throws exception when updating non-existent schedule exception', function () {
    ScheduleException::factory()->create();

    $result = $this->repository->getDoctorScheduleExceptionById(new IdObj(9999));

    expect($result)->toBeEmpty();
});

it('fetch schedule exception by doctor id', function () {
    $user = User::factory()->create();
    ScheduleException::factory()->count(5)->create([
        'user_id' => $user->id
    ]);

    $result = $this->repository->getDoctorScheduleExceptionByDoctorId(new IdObj($user->id));

    expect($result)->toHaveCount(5);
    expect($result->first())->toBeInstanceOf(ScheduleException::class);
});

it('add schedule exception', function () {
    $user = User::factory()->create();

    $data = new DoctorScheduleExceptionEntity(
        user_id: new IdObj($user->id),
        date: new DateObj('2025-07-26'),
        is_available: true,
        notes: 'vacation'
    );

    $result = $this->repository->addDoctorScheduleException($data);

    expect($result)->toBeInstanceOf(ScheduleException::class)
        ->and($result->date)->toBe('2025-07-26');
});

it('throws exception when exception date is present by doctor id', function () {
    $user = User::factory()->create();
    ScheduleException::factory()->create([
        "user_id" => $user->id,
        "date" => '2025-07-26',
        "is_available" => true,
        "notes" => 'vacation',
    ]);

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::DOCTOR_SCHEDULE_EXCEPTION_EXIST);

    $data = new DoctorScheduleExceptionEntity(
        user_id: new IdObj($user->id),
        date: new DateObj('2025-07-26'),
        is_available: true,
        notes: 'vacation'
    );

    $this->repository->addDoctorScheduleException($data);
});

it('update schedule exception', function () {
    $user = User::factory()->create();

    $exception = ScheduleException::factory()->create([
        "user_id" => $user->id,
        "date" => '2025-07-26',
        "is_available" => true,
        "notes" => 'vacation',
    ]);

    $data = new DoctorScheduleExceptionEntity(
        user_id: new IdObj($user->id),
        date: new DateObj('2025-07-27'),
        is_available: true,
        notes: 'vacations'
    );

    $result = $this->repository->updateDoctorScheduleException(new IdObj($exception->id), $data);

    expect($result)->toBeInstanceOf(ScheduleException::class)
        ->and($result->date)->toBe('2025-07-27');
});

it('throws exception when a doctor id is already exist when update', function () {
    $user = User::factory()->create();

    $exception = ScheduleException::factory()->create([
        "user_id" => $user->id,
        "date" => '2025-07-26',
        "is_available" => true,
        "notes" => 'vacation',
    ]);

    ScheduleException::factory()->create([
        "user_id" => $user->id,
        "date" => '2025-07-27',
        "is_available" => true,
        "notes" => 'vacation',
    ]);

    $data = new DoctorScheduleExceptionEntity(
        user_id: new IdObj($user->id),
        date: new DateObj('2025-07-27'),
        is_available: true,
        notes: 'vacations'
    );

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::DOCTOR_SCHEDULE_EXCEPTION_EXIST);


    $this->repository->updateDoctorScheduleException(new IdObj($exception->id), $data);
});
