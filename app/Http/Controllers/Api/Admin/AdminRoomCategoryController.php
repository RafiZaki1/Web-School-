<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Interfaces\RoomCategoryServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomCategory\StoreRoomCategoryRequest;
use App\Http\Requests\RoomCategory\UpdateRoomCategoryRequest;
use App\Http\Resources\RoomCategoryResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AdminRoomCategoryController extends Controller
{
    public function __construct(
        protected RoomCategoryServiceInterface $roomCategoryService
    ) {}

    public function index(): JsonResponse
    {
        try {
            $categories = $this->roomCategoryService->getAll();

            return ApiResponse::success(
                RoomCategoryResource::collection($categories),
                'Room categories retrieved successfully'
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve room categories: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(StoreRoomCategoryRequest $request): JsonResponse
    {
        try {
            $category = $this->roomCategoryService->create($request->validated());

            return ApiResponse::success(
                new RoomCategoryResource($category),
                'Room category created successfully',
                Response::HTTP_CREATED
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to create room category: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show(int|string $room_category): JsonResponse
    {
        try {
            $category = $this->roomCategoryService->getById($room_category);

            return ApiResponse::success(
                new RoomCategoryResource($category),
                'Room category retrieved successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Room category not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve room category: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(UpdateRoomCategoryRequest $request, int|string $room_category): JsonResponse
    {
        try {
            $updated = $this->roomCategoryService->update($room_category, $request->validated());

            return ApiResponse::success(
                new RoomCategoryResource($updated),
                'Room category updated successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Room category not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to update room category: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function destroy(int|string $room_category): JsonResponse
    {
        try {
            $this->roomCategoryService->delete($room_category);

            return ApiResponse::success(
                null,
                'Room category deleted successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Room category not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to delete room category: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
