<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Interfaces\HeroServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hero\StoreHeroRequest;
use App\Http\Requests\Hero\UpdateHeroRequest;
use App\Http\Resources\HeroResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class HeroController extends Controller
{
    public function __construct(
        protected HeroServiceInterface $heroService
    ) {}

    /**
     * Display a listing of all heroes.
     */
    public function index(): JsonResponse
    {
        try {
            $heroes = $this->heroService->getAll();

            return ApiResponse::success(
                HeroResource::collection($heroes),
                'Heroes retrieved successfully'
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve heroes: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Store a newly created hero.
     */
    public function store(StoreHeroRequest $request): JsonResponse
    {
        try {
            $hero = $this->heroService->create($request->validated());

            return ApiResponse::success(
                new HeroResource($hero),
                'Hero created successfully',
                Response::HTTP_CREATED
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to create hero: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Display the specified hero.
     */
    public function show(int|string $id): JsonResponse
    {
        try {
            $hero = $this->heroService->getById($id);

            return ApiResponse::success(
                new HeroResource($hero),
                'Hero retrieved successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Hero not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve hero: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Update the specified hero.
     */
    public function update(UpdateHeroRequest $request, int|string $id): JsonResponse
    {
        try {
            $hero = $this->heroService->update($id, $request->validated());

            return ApiResponse::success(
                new HeroResource($hero),
                'Hero updated successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Hero not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to update hero: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Remove the specified hero.
     */
    public function destroy(int|string $id): JsonResponse
    {
        try {
            $this->heroService->delete($id);

            return ApiResponse::success(
                null,
                'Hero deleted successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Hero not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to delete hero: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
