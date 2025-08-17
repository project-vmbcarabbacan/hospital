<?php

namespace App\Domain\ValueObjects;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class FileValueObj
{
    private string $originalName;
    private string $extension;
    private int $size;
    private string $mimeType;
    private UploadedFile $file;
    private ?string $storedPath = null;
    private string $disk;

    public function __construct(UploadedFile $file, string $disk = 'public')
    {
        if (!$file->isValid()) {
            throw new InvalidArgumentException('Invalid uploaded file.');
        }

        $this->file = $file;
        $this->originalName = $file->getClientOriginalName();
        $this->extension = $file->getClientOriginalExtension();
        $this->size = $file->getSize();
        $this->mimeType = $file->getClientMimeType();
        $this->disk = $disk;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    public function store(string $path): string
    {
        $this->storedPath = $this->file->store($path, $this->disk);
        return $this->storedPath;
    }

    public function storeAs(string $path, string $name): string
    {
        $this->storedPath = $this->file->storeAs($path, $name, $this->disk);
        return $this->storedPath;
    }

    public function getStoredPath(): ?string
    {
        return $this->storedPath;
    }

    public function getUrl(): ?string
    {
        return $this->storedPath ? Storage::disk($this->disk)->url($this->storedPath) : null;
    }
}
