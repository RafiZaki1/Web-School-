<?php

namespace App\Services;

use App\Contracts\FileUploadServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService implements FileUploadServiceInterface
{
    /**
     * Upload file to the specified directory on the public disk.
     */
    public function upload(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, 'public');
    }

    /**
     * Delete file from public disk if exists.
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Replace existing file with a new file.
     */
    public function replace(?UploadedFile $newFile, ?string $oldPath, string $directory): ?string
    {
        if ($newFile) {
            $this->delete($oldPath);
            return $this->upload($newFile, $directory);
        }

        return $oldPath;
    }

    /**
     * Get full public URL for a stored file path.
     */
    public function url(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        // If path is already a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return url(Storage::url($path));
    }
}
