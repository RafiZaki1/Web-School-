<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\HeroRepositoryInterface;
use App\Models\Hero;
use Illuminate\Database\Eloquent\Collection;

class HeroRepository implements HeroRepositoryInterface
{
    public function all(): Collection
    {
        return Hero::query()->ordered()->get();
    }

    public function active(): Collection
    {
        return Hero::query()->active()->ordered()->get();
    }

    public function firstActive(): ?Hero
    {
        return Hero::query()->active()->ordered()->first();
    }

    public function findOrFail(int|string $id): Hero
    {
        return Hero::query()->findOrFail($id);
    }

    public function create(array $data): Hero
    {
        return Hero::query()->create($data);
    }

    public function update(Hero $hero, array $data): Hero
    {
        $hero->update($data);

        return $hero->refresh();
    }

    public function delete(Hero $hero): bool
    {
        return (bool) $hero->delete();
    }
}
