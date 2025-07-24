<?php

namespace App\Abstracts;

use Illuminate\Support\Collection;
use App\Domain\Enums\RoleEnum;
use App\Domain\Enums\PermissionEnum;

abstract class AbstractRoleService
{
    abstract public function all(): Collection;

    abstract public function findById(int $id): ?array;

    abstract public function findByName(RoleEnum|string $name): ?array;

    abstract public function whereHasPermission(PermissionEnum|string $permission): Collection;
}
