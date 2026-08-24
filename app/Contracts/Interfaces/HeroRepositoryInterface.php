<?php

namespace App\Contracts\Interfaces;

use App\Models\Hero;
use Illuminate\Database\Eloquent\Collection;

interface HeroRepositoryInterface
{
    public function all(): Collection;

    public function active(): Collection;

    public function firstActive(): ?Hero;

    public function findOrFail(int|string $id): Hero;

    public function create(array $data): Hero;

    public function update(Hero $hero, array $data): Hero;

    public function delete(Hero $hero): bool;
}
