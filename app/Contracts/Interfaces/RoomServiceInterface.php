<?php
namespace App\Contracts\Interfaces;

use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

interface RoomServiceInterface
{
    /**
     * Get all active rooms for interactive floor plan.
     */
    public function getActiveRooms(): Collection;

    /**
     * Get detail of a room by ID or slug.
     */
    public function getRoomDetail(int|string $identifier): Room;

    /**
     * Get facilities belonging to a specific room by room ID or slug.
     */
    public function getRoomFacilities(int|string $identifier): Collection;
}
