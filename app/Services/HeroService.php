<?php

namespace App\Services;

use App\Contracts\FileUploadServiceInterface;
use App\Contracts\HeroServiceInterface;
use App\Models\Hero;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class HeroService implements HeroServiceInterface
{
    public function __construct(
        protected FileUploadServiceInterface $fileUploadService
    ) {}

    /**
     * Get all heroes ordered.
     */
    public function getAll(): Collection
    {
        return Hero::ordered()->get();
    }

    /**
     * Get active heroes for public view.
     */
    public function getActiveHeroes(): Collection
    {
        return Hero::active()->ordered()->get();
    }

    /**
     * Get single active hero for landing page.
     */
    public function getActiveHero(): ?Hero
    {
        return Hero::active()->ordered()->first();
    }

    /**
     * Find hero by id.
     */
    public function getById(int|string $id): Hero
    {
        return Hero::findOrFail($id);
    }

    /**
     * Create a new hero.
     */
    public function create(array $data): Hero
    {
        if (isset($data['background_image']) && $data['background_image'] instanceof UploadedFile) {
            $data['background_image'] = $this->fileUploadService->upload(
                $data['background_image'],
                'heroes'
            );
        }

        return Hero::create($data);
    }

    /**
     * Update an existing hero.
     */
    public function update(int|string $id, array $data): Hero
    {
        $hero = $this->getById($id);

        if (isset($data['background_image']) && $data['background_image'] instanceof UploadedFile) {
            $data['background_image'] = $this->fileUploadService->replace(
                $data['background_image'],
                $hero->background_image,
                'heroes'
            );
        }

        $hero->update($data);

        return $hero;
    }

    /**
     * Delete a hero and its associated background image.
     */
    public function delete(int|string $id): bool
    {
        $hero = $this->getById($id);

        if ($hero->background_image) {
            $this->fileUploadService->delete($hero->background_image);
        }

        return (bool) $hero->delete();
    }
}
