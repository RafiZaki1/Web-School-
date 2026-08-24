<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\GalleryRepositoryInterface;
use App\Models\Gallery;
use Illuminate\Database\Eloquent\Collection;

class GalleryRepository implements GalleryRepositoryInterface
{
    public function all(?string $category = null): Collection
    {
        return Gallery::query()->category($category)->ordered()->get();
    }

    public function active(?string $category = null): Collection
    {
        return Gallery::query()->active()->category($category)->ordered()->get();
    }

    public function findOrFail(int|string $id): Gallery
    {
        return Gallery::query()->findOrFail($id);
    }

    public function create(array $data): Gallery
    {
        return Gallery::query()->create($data);
    }

    public function update(Gallery $gallery, array $data): Gallery
    {
        $gallery->update($data);

        return $gallery->refresh();
    }

    public function delete(Gallery $gallery): bool
    {
        return (bool) $gallery->delete();
    }
}
