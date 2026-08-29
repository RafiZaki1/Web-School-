<?php

namespace App\Contracts\Interfaces;

use App\Models\Facility;
use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

interface RoomRepositoryInterface
{
    public function active(): Collection;

    public function getAllAdmin(): Collection;

    public function search(string $query): Collection;

    public function findByIdentifierOrFail(int|string $identifier): Room;

    public function create(array $data): Room;

    public function update(Room $room, array $data): Room;

    public function delete(Room $room): bool;

    public function facilities(Room $room): Collection;

    public function findFacilityOrFail(Room $room, int|string $facilityId): Facility;

    public function createFacility(Room $room, array $data): Facility;

    public function updateFacility(Facility $facility, array $data): Facility;

    public function deleteFacility(Facility $facility): bool;
}
