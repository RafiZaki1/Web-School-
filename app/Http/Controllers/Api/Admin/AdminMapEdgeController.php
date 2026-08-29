<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Interfaces\MapServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Map\StoreMapEdgeRequest;
use App\Http\Requests\Map\UpdateMapEdgeRequest;
use App\Http\Resources\MapEdgeResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AdminMapEdgeController extends Controller
{
    public function __construct(
        protected MapServiceInterface $mapService
    ) {}

    public function index(): JsonResponse
    {
        try {
            $edges = $this->mapService->getAllEdges();

            return ApiResponse::success(
                MapEdgeResource::collection($edges),
                'Map edges retrieved successfully'
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve map edges: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(StoreMapEdgeRequest $request): JsonResponse
    {
        try {
            $edge = $this->mapService->createEdge($request->validated());

            return ApiResponse::success(
                new MapEdgeResource($edge),
                'Map edge created successfully',
                Response::HTTP_CREATED
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to create map edge: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show(int|string $edge): JsonResponse
    {
        try {
            $edgeModel = $this->mapService->getEdgeById($edge);

            return ApiResponse::success(
                new MapEdgeResource($edgeModel),
                'Map edge retrieved successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Map edge not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve map edge: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(UpdateMapEdgeRequest $request, int|string $edge): JsonResponse
    {
        try {
            $updated = $this->mapService->updateEdge($edge, $request->validated());

            return ApiResponse::success(
                new MapEdgeResource($updated),
                'Map edge updated successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Map edge not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to update map edge: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function destroy(int|string $edge): JsonResponse
    {
        try {
            $this->mapService->deleteEdge($edge);

            return ApiResponse::success(
                null,
                'Map edge deleted successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Map edge not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to delete map edge: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
