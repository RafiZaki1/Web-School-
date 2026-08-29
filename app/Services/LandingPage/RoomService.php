<?php

namespace App\Services\LandingPage;

use App\Contracts\Interfaces\FileUploadServiceInterface;
use App\Contracts\Interfaces\RoomRepositoryInterface;
use App\Contracts\Interfaces\RoomServiceInterface;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class RoomService implements RoomServiceInterface
{
    public function __construct(
        protected RoomRepositoryInterface $roomRepository,
        protected FileUploadServiceInterface $fileUploadService,
    ) {}

    public function getActiveRooms(): Collection
    {
        return $this->roomRepository->active();
    }

    public function getAllAdminRooms(): Collection
    {
        return $this->roomRepository->getAllAdmin();
    }

    public function searchRooms(string $query): Collection
    {
        return $this->roomRepository->search($query);
    }

    public function getRoomDetail(int|string $identifier): Room
    {
        return $this->roomRepository->findByIdentifierOrFail($identifier);
    }

    public function createRoom(array $data): Room
    {
        if (empty($data['slug']) && !empty($data['name'])) {
            $baseSlug = Str::slug($data['name']);
            $slug = $baseSlug;
            $counter = 1;
            while (Room::where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $data['slug'] = $slug;
        }

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->fileUploadService->upload($data['image'], 'rooms');
        }

        return $this->roomRepository->create($data);
    }

    public function updateRoom(int|string $identifier, array $data): Room
    {
        $room = $this->getRoomDetail($identifier);

        if (empty($data['slug']) && !empty($data['name']) && $data['name'] !== $room->name) {
            $baseSlug = Str::slug($data['name']);
            $slug = $baseSlug;
            $counter = 1;
            while (Room::where('slug', $slug)->where('id', '!=', $room->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $data['slug'] = $slug;
        }

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->fileUploadService->replace(
                $data['image'],
                $room->image,
                'rooms'
            );
        }

        return $this->roomRepository->update($room, $data);
    }

    public function deleteRoom(int|string $identifier): bool
    {
        $room = $this->getRoomDetail($identifier);

        if ($room->image) {
            $this->fileUploadService->delete($room->image);
        }

        return $this->roomRepository->delete($room);
    }

    public function getRoomFacilities(int|string $identifier): Collection
    {
        return $this->roomRepository->facilities(
            $this->getRoomDetail($identifier)
        );
    }

    public function addFacility(int|string $identifier, array $data): Facility
    {
        $room = $this->getRoomDetail($identifier);
        return $this->roomRepository->createFacility($room, $data);
    }

    public function updateFacility(int|string $identifier, int|string $facilityId, array $data): Facility
    {
        $room = $this->getRoomDetail($identifier);
        $facility = $this->roomRepository->findFacilityOrFail($room, $facilityId);
        return $this->roomRepository->updateFacility($facility, $data);
    }

    public function deleteFacility(int|string $identifier, int|string $facilityId): bool
    {
        $room = $this->getRoomDetail($identifier);
        $facility = $this->roomRepository->findFacilityOrFail($room, $facilityId);
        return $this->roomRepository->deleteFacility($facility);
    }
}
