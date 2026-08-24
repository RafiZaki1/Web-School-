<?php

namespace App\Services;

use App\Contracts\FileUploadServiceInterface;
use App\Contracts\GalleryServiceInterface;
use App\Models\Gallery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class GalleryService implements GalleryServiceInterface
{
    public function __construct(
        protected FileUploadServiceInterface $fileUploadService
    ) {}

    /**
     * Get all galleries with optional category filter.
     */
    public function getAll(?string $category = null): Collection
    {
        return Gallery::category($category)->ordered()->get();
    }

    /**
     * Get active galleries for public view with optional category filter.
     */
    public function getActiveGalleries(?string $category = null): Collection
    {
        return Gallery::active()->category($category)->ordered()->get();
    }

    /**
     * Find gallery by id.
     */
    public function getById(int|string $id): Gallery
    {
        return Gallery::findOrFail($id);
    }

    /**
     * Create a new gallery item.
     */
    public function create(array $data): Gallery
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->fileUploadService->upload(
                $data['image'],
                'galleries'
            );
        }

        return Gallery::create($data);
    }

    /**
     * Update an existing gallery item.
     */
    public function update(int|string $id, array $data): Gallery
    {
        $gallery = $this->getById($id);

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->fileUploadService->replace(
                $data['image'],
                $gallery->image,
                'galleries'
            );
        }

        $gallery->update($data);

        return $gallery;
    }

    /**
     * Delete a gallery item and its image.
     */
    public function delete(int|string $id): bool
    {
        $gallery = $this->getById($id);

        if ($gallery->image) {
            $this->fileUploadService->delete($gallery->image);
        }

        return (bool) $gallery->delete();
    }
}
