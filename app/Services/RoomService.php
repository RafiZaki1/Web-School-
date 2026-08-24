<?php

namespace App\Services;

use App\Contracts\RoomServiceInterface;
use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

class RoomService implements RoomServiceInterface
{
    /**
     * Get all active rooms for interactive floor plan.
     */
    public function getActiveRooms(): Collection
    {
        return Room::active()->ordered()->get();
    }

    /**
     * Get detail of a room by ID or slug.
     */
    public function getRoomDetail(int|string $identifier): Room
    {
        if (is_numeric($identifier)) {
            return Room::where('id', $identifier)->firstOrFail();
        }

        return Room::where('slug', $identifier)->firstOrFail();
    }

    /**
     * Get facilities belonging to a specific room by room ID or slug.
     */
    public function getRoomFacilities(int|string $identifier): Collection
    {
        $room = $this->getRoomDetail($identifier);

        return $room->facilities()->orderBy('id', 'asc')->get();
    }
}
