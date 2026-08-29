<?php

namespace App\Services\LandingPage;

use App\Contracts\Interfaces\RoomCategoryRepositoryInterface;
use App\Contracts\Interfaces\RoomCategoryServiceInterface;
use App\Models\RoomCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class RoomCategoryService implements RoomCategoryServiceInterface
{
    public function __construct(
        protected RoomCategoryRepositoryInterface $roomCategoryRepository,
    ) {}

    public function getAll(): Collection
    {
        return $this->roomCategoryRepository->getAll();
    }

    public function getActive(): Collection
    {
        return $this->roomCategoryRepository->getActive();
    }

    public function getById(int|string $identifier): RoomCategory
    {
        return $this->roomCategoryRepository->findByIdentifierOrFail($identifier);
    }

    public function create(array $data): RoomCategory
    {
        if (empty($data['slug']) && !empty($data['name'])) {
            $baseSlug = Str::slug($data['name']);
            $slug = $baseSlug;
            $counter = 1;
            while (RoomCategory::where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $data['slug'] = $slug;
        }

        return $this->roomCategoryRepository->create($data);
    }

    public function update(int|string $identifier, array $data): RoomCategory
    {
        $category = $this->getById($identifier);

        if (empty($data['slug']) && !empty($data['name']) && $data['name'] !== $category->name) {
            $baseSlug = Str::slug($data['name']);
            $slug = $baseSlug;
            $counter = 1;
            while (RoomCategory::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $data['slug'] = $slug;
        }

        return $this->roomCategoryRepository->update($category, $data);
    }

    public function delete(int|string $identifier): bool
    {
        $category = $this->getById($identifier);
        return $this->roomCategoryRepository->delete($category);
    }
}
