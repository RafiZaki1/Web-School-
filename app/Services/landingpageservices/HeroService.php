<?php

namespace App\Services\landingpageservices;

use App\Contracts\Interfaces\FileUploadServiceInterface;
use App\Contracts\Interfaces\HeroRepositoryInterface;
use App\Contracts\Interfaces\HeroServiceInterface;
use App\Models\Hero;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class HeroService implements HeroServiceInterface
{
    public function __construct(
        protected FileUploadServiceInterface $fileUploadService,
        protected HeroRepositoryInterface $heroRepository,
    ) {}

    /**
     * Get all heroes ordered.
     */
    public function getAll(): Collection
    {
        return $this->heroRepository->all();
    }

    /**
     * Get active heroes for public view.
     */
    public function getActiveHeroes(): Collection
    {
        return $this->heroRepository->active();
    }

    /**
     * Get single active hero for landing page.
     */
    public function getActiveHero(): ?Hero
    {
        return $this->heroRepository->firstActive();
    }

    /**
     * Find hero by id.
     */
    public function getById(int|string $id): Hero
    {
        return $this->heroRepository->findOrFail($id);
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

        return $this->heroRepository->create($data);
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

        return $this->heroRepository->update($hero, $data);
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

        return $this->heroRepository->delete($hero);
    }
}
