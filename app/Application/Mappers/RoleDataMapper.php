<?php

namespace App\Application\Mappers;

use Illuminate\Support\Collection;

class RoleDataMapper
{
    public function map(array $rawData): Collection
    {
        return collect($rawData['roles'] ?? []);
    }
}
