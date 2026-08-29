<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Interfaces\RoomServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Facility\StoreFacilityRequest;
use App\Http\Requests\Facility\UpdateFacilityRequest;
use App\Http\Resources\FacilityResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AdminFacilityController extends Controller
{
    public function __construct(
        protected RoomServiceInterface $roomService
    ) {}

    /**
     * Display a listing of facilities for the specified room.
     */
    public function index(int|string $room): JsonResponse
    {
        try {
            $facilities = $this->roomService->getRoomFacilities($room);

            return ApiResponse::success(
                FacilityResource::collection($facilities),
                'Facilities retrieved successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Room not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve facilities: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Store a newly created facility for the room.
     */
    public function store(StoreFacilityRequest $request, int|string $room): JsonResponse
    {
        try {
            $facility = $this->roomService->addFacility($room, $request->validated());

            return ApiResponse::success(
                new FacilityResource($facility),
                'Facility created successfully',
                Response::HTTP_CREATED
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Room not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to create facility: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Update the specified facility in the room.
     */
    public function update(UpdateFacilityRequest $request, int|string $room, int|string $facility): JsonResponse
    {
        try {
            $updated = $this->roomService->updateFacility($room, $facility, $request->validated());

            return ApiResponse::success(
                new FacilityResource($updated),
                'Facility updated successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Room or facility not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to update facility: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Remove the specified facility from the room.
     */
    public function destroy(int|string $room, int|string $facility): JsonResponse
    {
        try {
            $this->roomService->deleteFacility($room, $facility);

            return ApiResponse::success(
                null,
                'Facility deleted successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Room or facility not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to delete facility: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
