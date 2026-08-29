<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Interfaces\RoomServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Http\Resources\RoomDetailResource;
use App\Http\Resources\RoomResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AdminRoomController extends Controller
{
    public function __construct(
        protected RoomServiceInterface $roomService
    ) {}

    /**
     * Display a listing of all rooms for admin.
     */
    public function index(): JsonResponse
    {
        try {
            $rooms = $this->roomService->getAllAdminRooms();

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
     * Store a newly created room.
     */
    public function store(StoreRoomRequest $request): JsonResponse
    {
        try {
            $room = $this->roomService->createRoom($request->validated());

            return ApiResponse::success(
                new RoomDetailResource($room),
                'Room created successfully',
                Response::HTTP_CREATED
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to create room: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Display the specified room.
     */
    public function show(int|string $id): JsonResponse
    {
        try {
            $room = $this->roomService->getRoomDetail($id);

            return ApiResponse::success(
                new RoomDetailResource($room),
                'Room retrieved successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Room not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve room: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Update the specified room.
     */
    public function update(UpdateRoomRequest $request, int|string $id): JsonResponse
    {
        try {
            $room = $this->roomService->updateRoom($id, $request->validated());

            return ApiResponse::success(
                new RoomDetailResource($room),
                'Room updated successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Room not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to update room: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Remove the specified room.
     */
    public function destroy(int|string $id): JsonResponse
    {
        try {
            $this->roomService->deleteRoom($id);

            return ApiResponse::success(
                null,
                'Room deleted successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Room not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to delete room: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
