<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Interfaces\MapServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Map\StoreMapNodeRequest;
use App\Http\Requests\Map\UpdateMapNodeRequest;
use App\Http\Resources\MapNodeResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AdminMapNodeController extends Controller
{
    public function __construct(
        protected MapServiceInterface $mapService
    ) {}

    public function index(): JsonResponse
    {
        try {
            $nodes = $this->mapService->getAllNodes();

            return ApiResponse::success(
                MapNodeResource::collection($nodes),
                'Map nodes retrieved successfully'
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve map nodes: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(StoreMapNodeRequest $request): JsonResponse
    {
        try {
            $node = $this->mapService->createNode($request->validated());

            return ApiResponse::success(
                new MapNodeResource($node),
                'Map node created successfully',
                Response::HTTP_CREATED
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to create map node: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show(int|string $node): JsonResponse
    {
        try {
            $nodeModel = $this->mapService->getNodeById($node);

            return ApiResponse::success(
                new MapNodeResource($nodeModel),
                'Map node retrieved successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Map node not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve map node: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(UpdateMapNodeRequest $request, int|string $node): JsonResponse
    {
        try {
            $updated = $this->mapService->updateNode($node, $request->validated());

            return ApiResponse::success(
                new MapNodeResource($updated),
                'Map node updated successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Map node not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to update map node: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function destroy(int|string $node): JsonResponse
    {
        try {
            $this->mapService->deleteNode($node);

            return ApiResponse::success(
                null,
                'Map node deleted successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Map node not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to delete map node: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
