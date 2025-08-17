<?php

namespace App\Domain\Interfaces\Services;


interface ImageServiceInterface
{
    public function deletePreviousImage(string $path, string $disk);
}
