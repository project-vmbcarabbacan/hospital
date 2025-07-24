<?php

namespace App\Domain\Interfaces\Services;

use App\Domain\ValueObjects\RoleIdObj;

interface RoleServiceInterface
{
    public function getPermissionsByRoleId(RoleIdObj $roleId);
    public function getRoleName(RoleIdObj $roleId);
}
