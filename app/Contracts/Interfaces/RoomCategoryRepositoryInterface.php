<?php

namespace App\Contracts\Interfaces;

use App\Models\RoomCategory;
use Illuminate\Database\Eloquent\Collection;

interface RoomCategoryRepositoryInterface
{
    public function getAll(): Collection;

    public function getActive(): Collection;

    public function findByIdentifierOrFail(int|string $identifier): RoomCategory;

    public function create(array $data): RoomCategory;

    public function update(RoomCategory $category, array $data): RoomCategory;

    public function delete(RoomCategory $category): bool;
}
