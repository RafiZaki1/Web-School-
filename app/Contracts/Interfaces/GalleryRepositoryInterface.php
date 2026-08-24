<?php

namespace App\Contracts\Interfaces;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Collection;

interface GalleryRepositoryInterface
{
    public function all(?string $category = null): Collection;

    public function active(?string $category = null): Collection;

    public function findOrFail(int|string $id): Gallery;

    public function create(array $data): Gallery;

    public function update(Gallery $gallery, array $data): Gallery;

    public function delete(Gallery $gallery): bool;
}
