<?php

namespace App\Contracts\Interfaces;

use App\Models\RoomCategory;
use Illuminate\Database\Eloquent\Collection;

interface RoomCategoryServiceInterface
{
    public function getAll(): Collection;

    public function getActive(): Collection;

    public function getById(int|string $identifier): RoomCategory;

    public function create(array $data): RoomCategory;

    public function update(int|string $identifier, array $data): RoomCategory;

    public function delete(int|string $identifier): bool;
}
