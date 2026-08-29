<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\RoomRepositoryInterface;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

class RoomRepository implements RoomRepositoryInterface
{
    public function active(): Collection
    {
        return Room::query()
            ->active()
            ->ordered()
            ->with(['category', 'facilities', 'mapNode'])
            ->get();
    }

    public function getAllAdmin(): Collection
    {
        return Room::query()
            ->ordered()
            ->with(['category', 'facilities', 'mapNode'])
            ->get();
    }

    public function search(string $query): Collection
    {
        $term = trim($query);

        return Room::query()
            ->active()
            ->with(['category', 'facilities', 'mapNode'])
            ->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('slug', 'like', "%{$term}%")
                    ->orWhere('building_name', 'like', "%{$term}%")
                    ->orWhereHas('category', function ($catQuery) use ($term) {
                        $catQuery->where('name', 'like', "%{$term}%")
                            ->orWhere('slug', 'like', "%{$term}%");
                    });
            })
            ->ordered()
            ->get();
    }

    public function findByIdentifierOrFail(int|string $identifier): Room
    {
        $query = Room::query()->with(['category', 'facilities', 'mapNode']);

        if (is_numeric($identifier)) {
            return $query->whereKey($identifier)->firstOrFail();
        }

        return $query->where('slug', $identifier)->firstOrFail();
    }

    public function create(array $data): Room
    {
        return Room::create($data);
    }

    public function update(Room $room, array $data): Room
    {
        $room->update($data);
        return $room->fresh(['category', 'facilities', 'mapNode']);
    }

    public function delete(Room $room): bool
    {
        return (bool) $room->delete();
    }

    public function facilities(Room $room): Collection
    {
        return $room->facilities()->orderBy('id')->get();
    }

    public function findFacilityOrFail(Room $room, int|string $facilityId): Facility
    {
        return $room->facilities()->whereKey($facilityId)->firstOrFail();
    }

    public function createFacility(Room $room, array $data): Facility
    {
        return $room->facilities()->create($data);
    }

    public function updateFacility(Facility $facility, array $data): Facility
    {
        $facility->update($data);
        return $facility->fresh();
    }

    public function deleteFacility(Facility $facility): bool
    {
        return (bool) $facility->delete();
    }
}
