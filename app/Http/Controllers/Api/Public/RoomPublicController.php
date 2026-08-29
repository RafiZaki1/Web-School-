<?php

namespace App\Http\Controllers\Api\Public;

use App\Contracts\Interfaces\RoomServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\FacilityResource;
use App\Http\Resources\RoomDetailResource;
use App\Http\Resources\RoomResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RoomPublicController extends Controller
{
    public function __construct(
        protected RoomServiceInterface $roomService
    ) {}

    /**
     * Display a listing of all active rooms.
     */
    public function index(): JsonResponse
    {
        try {
            $rooms = $this->roomService->getActiveRooms();

            return ApiResponse::success(
                RoomResource::collection($rooms),
                'Rooms retrieved successfully'
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve rooms: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Display the specified room details.
     */
    public function show(int|string $room): JsonResponse
    {
        try {
            $roomDetail = $this->roomService->getRoomDetail($room);

            return ApiResponse::success(
                new RoomDetailResource($roomDetail),
                'Room detail retrieved successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Room not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve room detail: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Display the facilities for the specified room.
     */
    public function facilities(int|string $room): JsonResponse
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
                'Failed to retrieve room facilities: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Search rooms by query keyword.
     */
    public function search(\Illuminate\Http\Request $request): JsonResponse
    {
        $query = $request->query('q');

        if ($query === null || trim((string) $query) === '') {
            return ApiResponse::error(
                "Parameter pencarian 'q' wajib diisi.",
                null,
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $rooms = $this->roomService->searchRooms((string) $query);

            return ApiResponse::success(
                RoomResource::collection($rooms),
                'Rooms search results retrieved successfully'
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to search rooms: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
