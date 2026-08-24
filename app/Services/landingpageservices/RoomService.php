<?php

namespace App\Services\landingpageservices;

use App\Contracts\Interfaces\RoomServiceInterface;
use App\Contracts\Interfaces\RoomRepositoryInterface;
use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

class RoomService implements RoomServiceInterface
{
    public function __construct(
        protected RoomRepositoryInterface $roomRepository,
    ) {}

    /**
     * Get all active rooms for interactive floor plan.
     */
    public function getActiveRooms(): Collection
    {
        return $this->roomRepository->active();
    }

    /**
     * Get detail of a room by ID or slug.
     */
    public function getRoomDetail(int|string $identifier): Room
    {
        return $this->roomRepository->findByIdentifierOrFail($identifier);
    }

    /**
     * Get facilities belonging to a specific room by room ID or slug.
     */
    public function getRoomFacilities(int|string $identifier): Collection
    {
        return $this->roomRepository->facilities(
            $this->getRoomDetail($identifier)
        );
    }
}
