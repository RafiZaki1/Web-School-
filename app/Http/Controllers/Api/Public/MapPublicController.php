<?php

namespace App\Http\Controllers\Api\Public;

use App\Contracts\Interfaces\MapRoutingServiceInterface;
use App\Contracts\Interfaces\MapServiceInterface;
use App\Contracts\Interfaces\RoomCategoryServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Map\RouteRequest;
use App\Http\Resources\MapNodeResource;
use App\Http\Resources\MapRouteResource;
use App\Http\Resources\RoomCategoryResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class MapPublicController extends Controller
{
    public function __construct(
        protected MapRoutingServiceInterface $mapRoutingService,
        protected MapServiceInterface $mapService,
        protected RoomCategoryServiceInterface $roomCategoryService,
    ) {}

    /**
     * Calculate route from origin room to destination room.
     */
    public function route(RouteRequest $request): JsonResponse
    {
        try {
            $from = $request->input('from');
            $to = $request->input('to');

            $result = $this->mapRoutingService->calculateRoute($from, $to);

            return ApiResponse::success(
                new MapRouteResource($result),
                'Rute perjalanan berhasil dihitung'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Ruangan asal atau tujuan tidak ditemukan.',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error(
                $e->getMessage(),
                null,
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                $th->getMessage(),
                null,
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Get all active room categories.
     */
    public function categories(): JsonResponse
    {
        try {
            $categories = $this->roomCategoryService->getActive();

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

    /**
     * Get all walkable map nodes for interactive floorplan layer.
     */
    public function nodes(): JsonResponse
    {
        try {
            $nodes = $this->mapService->getWalkableNodes();

            return ApiResponse::success(
                MapNodeResource::collection($nodes),
                'Walkable map nodes retrieved successfully'
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve map nodes: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
