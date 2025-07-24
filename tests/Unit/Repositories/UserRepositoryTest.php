<?php

use App\Domain\ValueObjects\EmailObj;
use App\Domain\ValueObjects\IdObj;
use App\Domain\ValueObjects\RoleIdObj;
use App\Models\User;
use App\Infrastructure\Repositories\UserRepository;
use App\Domain\Enums\RoleEnum;
use App\Models\UserInformation;

beforeEach(closure: function () {
    $role_id = RoleEnum::SUPER_ADMIN;
    $this->userRepository = app(UserRepository::class);

    $this->user = User::factory()->create([
        'email' => 'test@domain.com',
        'password' => 'password123',
        'role_id' => $role_id->value,
    ]);

    $this->information = UserInformation::factory()->create([
        'user_id' => $this->user->id,
        'phone' => 568215626
    ]);
});

it('finds a user by id', function () {
    $found = $this->userRepository->findById(new IdObj($this->user->id));

    expect($found)->not->toBeNull()
        ->and($found)->toBeInstanceOf(User::class);
});

it('user id is not present from the User table', function () {
    $found = $this->userRepository->findById(new IdObj(2));

    expect($found)->toBeNull();
});

it('finds a user information by phone number', function () {
    $found = $this->userRepository->findByPhone(568215626);

    expect($found)->not->toBeNull()
        ->and($found)->toBeInstanceOf(User::class);
});

it('user information phone is not present from the User table', function () {
    $found = $this->userRepository->findByPhone(568262231);

    expect($found)->toBeNull();
});

it('finds a user by email', function () {
    $email = new EmailObj('test@domain.com');
    $found = $this->userRepository->findByEmail($email);

    expect($found)->not->toBeNull()
        ->and($found->id)->toEqual($this->user->id);
});

it('user email is not present from the User table', function () {
    $email = new EmailObj('test@test.com');
    $found = $this->userRepository->findByEmail($email);

    expect($found)->toBeNull();
});

it('finds users by role', function () {
    $found = $this->userRepository->findByRole(new RoleIdObj(1));

    expect($found)->not->toBeNull();
});

it('user role is not present from the User table', function () {
    $found = $this->userRepository->findByRole(new RoleIdObj(13));

    expect($found)->toBeEmpty();
});
