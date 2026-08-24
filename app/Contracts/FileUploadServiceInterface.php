<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface FileUploadServiceInterface
{
    public function upload(UploadedFile $file, string $directory): string;

    public function delete(?string $path): void;

    public function replace(?UploadedFile $newFile, ?string $oldPath, string $directory): ?string;

    public function url(?string $path): ?string;
}
