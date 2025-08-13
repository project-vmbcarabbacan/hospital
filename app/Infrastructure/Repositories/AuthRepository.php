<?php

namespace App\Infrastructure\Repositories;

use App\Application\DTOs\CreateUserDto;
use App\Domain\Entities\UserEntity;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Domain\Interfaces\Repositories\AuthRepositoryInterface;
use App\Application\Utils\ExceptionConstants;
use App\Domain\Entities\UserInformationEntity;
use App\Domain\ValueObjects\EmailObj;
use App\Domain\ValueObjects\IdObj;
use App\Domain\ValueObjects\PasswordObj;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Exception;

class AuthRepository implements AuthRepositoryInterface
{

    public function login(EmailObj $email, PasswordObj $password): User
    {
        if (!Auth::attempt(['email' => $email->value(), 'password' => $password->value()])) {
            throw new Exception(ExceptionConstants::LOGIN_INVALID);
        }

        return auth('sanctum')->user();
    }

    public function createUser(CreateUserDto $dto): User
    {
        try {
            $userEntity = new UserEntity(
                name: $dto->first_name . ' ' . $dto->last_name,
                email: $dto->email,
                role_id: $dto->role_id,
                status: $dto->status,
                specialization_id: $dto->specialization_id,
                password: $dto->password,
            );

            $user = $this->createBaseUser($userEntity);

            $information = new UserInformationEntity(
                first_name: $dto->first_name,
                last_name: $dto->last_name,
                phone: $dto->phone,
                title: $dto->title,
                address: $dto->address,
                birthdate: $dto->birthdate,
                gender: $dto->gender,
                bio: $dto->bio,
                license_number: $dto->license_number,
                license_expiry: $dto->license_expiry,
                hired_date: $dto->hired_date,
                is_visible: $dto->is_visible,
                days_of_working: $dto->days_of_working,
                work_timing: $dto->work_timing,
                occupation_type: $dto->occupation_type,
                profile_photo: $dto->profile_photo,
            );
            $this->createUserInformation($user, $information);

            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updatePassword(IdObj $id, PasswordObj $password): User
    {
        $user = app(UserRepository::class)->findById($id);
        if (!$user)
            throw new Exception(ExceptionConstants::USER_NOT_FOUND);

        $user->password = $password->value();
        $user->save();

        return $user;
    }

    public function sendForgotPasswordCode(EmailObj $email)
    {
        $user = app(UserRepository::class)->findByEmail($email);
        if (!$user)
            throw new Exception(ExceptionConstants::USER_NOT_FOUND);

        $token = Str::upper(Str::random(6));

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => bcrypt($token),
                'created_at' => now()
            ]
        );

        /*
            Pending
            1. trigger an event to send sms and email
        */
    }

    protected function createBaseUser(UserEntity $data): User
    {
        try {
            return User::create([
                'name'     => $data->name,
                'email'    => $data->email->value(),
                'password' => $data->password->value(),
                'role_id'  => $data->role_id,
                'status'   => $data->status,
            ]);
        } catch (Exception $e) {
            throw new Exception(ExceptionConstants::USER_CREATE);
        }
    }

    protected function createUserInformation(User $user, UserInformationEntity $data): void
    {
        try {
            $user->information()->create([
                'first_name'         => $data->first_name ?? null,
                'last_name'         => $data->last_name ?? null,
                'title'         => $data->title ?? null,
                'phone'         => $data->phone ?? null,
                'address'       => $data->address ?? null,
                'birthdate'     => $data->birthdate ? $data->birthdate->value() : null,
                'gender'        => $data->gender ?? null,
                'bio'        => $data->bio ?? null,
                'license_number'        => $data->license_number ?? null,
                'license_expiry'        => $data->license_expiry ? $data->license_expiry->value() : null,
                'hired_date'        => $data->hired_date ? $data->hired_date->value() : null,
                'is_visible'        => $data->is_visible ?? true,
                'days_of_working' => $data->days_of_working ?? null,
                'work_timing' => $data->work_timing ?? null,
                'occupation_type' => $data->occupation_type ?? null,
                'profile_photo' => $data->profile_photo ?? null,
            ]);
        } catch (Exception $e) {
            throw new Exception(ExceptionConstants::USER_INFORMATION_CREATE);
        }
    }
}
