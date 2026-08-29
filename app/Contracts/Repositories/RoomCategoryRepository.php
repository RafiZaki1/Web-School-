<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\RoomCategoryRepositoryInterface;
use App\Models\RoomCategory;
use Illuminate\Database\Eloquent\Collection;

class RoomCategoryRepository implements RoomCategoryRepositoryInterface
{
    public function getAll(): Collection
    {
        return RoomCategory::query()->orderBy('id')->get();
    }

    public function getActive(): Collection
    {
        return RoomCategory::query()->active()->orderBy('id')->get();
    }

    public function findByIdentifierOrFail(int|string $identifier): RoomCategory
    {
        if (is_numeric($identifier)) {
            return RoomCategory::whereKey($identifier)->firstOrFail();
        }

        return RoomCategory::where('slug', $identifier)->firstOrFail();
    }

    public function create(array $data): RoomCategory
    {
        return RoomCategory::create($data);
    }

    public function update(RoomCategory $category, array $data): RoomCategory
    {
        $category->update($data);
        return $category->fresh();
    }

    public function delete(RoomCategory $category): bool
    {
        return (bool) $category->delete();
    }
}
