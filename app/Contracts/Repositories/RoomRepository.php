<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\RoomRepositoryInterface;
use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

class RoomRepository implements RoomRepositoryInterface
{
    public function active(): Collection
    {
        return Room::query()->active()->ordered()->with('facilities')->get();
    }

    public function findByIdentifierOrFail(int|string $identifier): Room
    {
        $query = Room::query()->with('facilities');

        if (is_numeric($identifier)) {
            return $query->whereKey($identifier)->firstOrFail();
        }

        return $query->where('slug', $identifier)->firstOrFail();
    }

    public function facilities(Room $room): Collection
    {
        return $room->facilities()->orderBy('id')->get();
    }
}
