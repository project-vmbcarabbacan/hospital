<?php

namespace App\Readers;

use Illuminate\Support\Facades\Storage;

class RoleFileReader
{
    protected string $path = 'roles.json';

    public function read(): array
    {
        $content = Storage::disk('local')->get($this->path);
        return json_decode($content, true);
    }
}
