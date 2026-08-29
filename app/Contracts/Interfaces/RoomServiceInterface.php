<?php

namespace App\Contracts\Interfaces;

use App\Models\Facility;
use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

interface RoomServiceInterface
{
    public function getActiveRooms(): Collection;

    public function getAllAdminRooms(): Collection;

    public function searchRooms(string $query): Collection;

    public function getRoomDetail(int|string $identifier): Room;

    public function createRoom(array $data): Room;

    public function updateRoom(int|string $identifier, array $data): Room;

    public function deleteRoom(int|string $identifier): bool;

    public function getRoomFacilities(int|string $identifier): Collection;

    public function addFacility(int|string $identifier, array $data): Facility;

    public function updateFacility(int|string $identifier, int|string $facilityId, array $data): Facility;

    public function deleteFacility(int|string $identifier, int|string $facilityId): bool;
}
