<?php

namespace App\Contracts\Interfaces;

use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

interface RoomRepositoryInterface
{
    public function active(): Collection;

    public function findByIdentifierOrFail(int|string $identifier): Room;

    public function facilities(Room $room): Collection;
}
