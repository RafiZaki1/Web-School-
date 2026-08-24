<?php

namespace App\Contracts;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Collection;

interface GalleryServiceInterface
{
    public function getAll(?string $category = null): Collection;

    public function getActiveGalleries(?string $category = null): Collection;

    public function getById(int|string $id): Gallery;

    public function create(array $data): Gallery;

    public function update(int|string $id, array $data): Gallery;

    public function delete(int|string $id): bool;
}
