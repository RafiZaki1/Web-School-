<?php

namespace App\Contracts;

use App\Models\Hero;
use Illuminate\Database\Eloquent\Collection;

interface HeroServiceInterface
{
    public function getAll(): Collection;

    public function getActiveHeroes(): Collection;

    public function getActiveHero(): ?Hero;

    public function getById(int|string $id): Hero;

    public function create(array $data): Hero;

    public function update(int|string $id, array $data): Hero;

    public function delete(int|string $id): bool;
}
