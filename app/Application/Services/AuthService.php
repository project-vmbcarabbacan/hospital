<?php

namespace App\Application\Services;

use App\Application\DTOs\CreateUserDto;
use App\Application\DTOs\LoginDto;
use App\Domain\Interfaces\Repositories\AuthRepositoryInterface;
use App\Domain\Interfaces\Services\AuthServiceInterface;
use App\Domain\Interfaces\Services\RoleServiceInterface;
use App\Domain\ValueObjects\EmailObj;
use App\Domain\ValueObjects\RoleIdObj;
use Exception;

class AuthService implements AuthServiceInterface
{

    public function __construct(protected AuthRepositoryInterface $authRepositoryInterface, protected RoleServiceInterface $role) {}

    public function login(LoginDto $dto)
    {
        try {
            $user = $this->authRepositoryInterface->login($dto->email, $dto->password);

            $role = $this->getRoleAndPermissions(new RoleIdObj($user->role_id));

            $token = $user->createToken($role['name'], $role['permissions'])->plainTextToken;
            return ['token' => $token, 'user' => $user];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function createUser(CreateUserDto $data) {
        try {
            $user = $this->authRepositoryInterface->createUser($data);

            $role = $this->getRoleAndPermissions(new RoleIdObj($user->role_id));

            $token = $user->createToken($role['name'], $role['permissions'])->plainTextToken;

            return ['token' => $token, 'user' => $user];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function getRoleAndPermissions(RoleIdObj $roleId) {
        $role = $this->role->getRoleName($roleId);
        $permissions = $this->role->getPermissionsByRoleId($roleId);

        return ['name' => $role, 'permissions' => $permissions];
    }
}
