<?php

namespace App\Application\Services;

use App\Domain\Interfaces\Services\ImageServiceInterface;
use Illuminate\Support\Facades\Storage;

class ImageService implements ImageServiceInterface
{

    public function deletePreviousImage(string $path, string $disk)
    {
        if (Storage::disk($disk)->exists($path) && $path) {
            Storage::disk($disk)->delete($path);

            return response()->json([
                'message' => 'Image successfully deleted.'
            ]);
        }
    }
}
