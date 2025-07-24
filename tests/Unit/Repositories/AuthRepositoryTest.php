<?php

use App\Application\DTOs\CreateUserDto;
use App\Domain\Enums\RoleEnum;
use App\Domain\ValueObjects\EmailObj;
use App\Domain\ValueObjects\IdObj;
use App\Models\User;
use App\Infrastructure\Repositories\AuthRepository;
use App\Application\Utils\ExceptionConstants;
use App\Domain\ValueObjects\PasswordObj;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->authRepository = app(AuthRepository::class);
});

test('successful login returns authenticated user', function () {
    $role_id = RoleEnum::SUPER_ADMIN;
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('Password123'),
        'role_id' => $role_id->value,
    ]);

    $email = new EmailObj('test@example.com');
    $password = new PasswordObj('Password123');

    $result = $this->authRepository->login($email, $password);

    expect($result)->toBeInstanceOf(User::class)
        ->and($result->id)->toBe($user->id);
});

test('login fails with invalid credentials', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('correct_password'),
    ]);

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::LOGIN_INVALID);

    $email = new EmailObj('test@example.com');
    $password = new PasswordObj('Wrong_password123');

    $this->authRepository->login($email, $password);
});

test('create user success', function() {
    $role_id = RoleEnum::SUPER_ADMIN;
    $data = [
        "name" => "Vincent mark carabbacan",
        "email" => "vmbcarabbacan@gmail.com",
        "password" => "Password123",
        "role_id" => $role_id->value,
        "status" => "active",
        "user_id" => 1,
        "phone" => 566368879,
        "address" => "Dubai, Dubai",
        "birthdate" => "1992-03-15",
        "gender" => "male",
        "profile_photo" => "",
    ];

    $dto  = CreateUserDto::fromArray($data);

    expect($dto)->toBeInstanceOf(CreateUserDto::class)
        ->and($dto->email)->toBeInstanceOf(EmailObj::class)
        ->and($dto->password)->toBeInstanceOf(PasswordObj::class)
        ->and($dto->email->value())->toBe('vmbcarabbacan@gmail.com');

    $result = $this->authRepository->createUser($dto );
    expect($result)->toBeInstanceOf(User::class);
});

test('update user password', function() {
    $role_id = RoleEnum::SUPER_ADMIN;
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('Password123'),
        'role_id' => $role_id->value,
    ]);

    $user_id = new IdObj($user->id);

    $result = $this->authRepository->updatePassword($user_id, new PasswordObj('Password456', true));
    expect($result)->toBeInstanceOf(User::class);
});

test('send password token to the email address', function() {
    $role_id = RoleEnum::SUPER_ADMIN;
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => 'password123',
        'role_id' => $role_id->value,
    ]);

    $email = new EmailObj('test@example.com');

    $result = $this->authRepository->sendForgotPasswordCode($email);
    expect($result)->toBeNull();
});
