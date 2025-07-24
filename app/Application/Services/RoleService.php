<?php

namespace App\Application\Services;

use App\Infrastructure\Readers\RoleFileReader;
use App\Application\Mappers\RoleDataMapper;
use App\Domain\Interfaces\Services\RoleServiceInterface;
use App\Domain\ValueObjects\RoleIdObj;

class RoleService implements RoleServiceInterface
{
    public function __construct(
        protected RoleFileReader $reader,
        protected RoleDataMapper $mapper
    ) {}

    public function getPermissionsByRoleId(RoleIdObj $roleId): array
    {
        $roles = $this->mapper->map($this->reader->read());

        return $roles->firstWhere('id', $roleId->value())['permissions'] ?? [];
    }

    public function getRoleName(RoleIdObj $roleId): string
    {
        $roles = $this->mapper->map($this->reader->read());

        return $roles->firstWhere('id', $roleId->value())['name'] ?? 'Auth';
    }
}
