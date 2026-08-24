<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Interfaces\GalleryServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\StoreGalleryRequest;
use App\Http\Requests\Gallery\UpdateGalleryRequest;
use App\Http\Resources\GalleryResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class GalleryController extends Controller
{
    public function __construct(
        protected GalleryServiceInterface $galleryService
    ) {}

    /**
     * Display a listing of all galleries.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $galleries = $this->galleryService->getAll($request->query('category'));

            return ApiResponse::success(
                GalleryResource::collection($galleries),
                'Galleries retrieved successfully'
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve galleries: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Store a newly created gallery.
     */
    public function store(StoreGalleryRequest $request): JsonResponse
    {
        try {
            $gallery = $this->galleryService->create($request->validated());

            return ApiResponse::success(
                new GalleryResource($gallery),
                'Gallery created successfully',
                Response::HTTP_CREATED
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to create gallery: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Display the specified gallery.
     */
    public function show(int|string $id): JsonResponse
    {
        try {
            $gallery = $this->galleryService->getById($id);

            return ApiResponse::success(
                new GalleryResource($gallery),
                'Gallery retrieved successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Gallery not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve gallery: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Update the specified gallery.
     */
    public function update(UpdateGalleryRequest $request, int|string $id): JsonResponse
    {
        try {
            $gallery = $this->galleryService->update($id, $request->validated());

            return ApiResponse::success(
                new GalleryResource($gallery),
                'Gallery updated successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Gallery not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to update gallery: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Remove the specified gallery.
     */
    public function destroy(int|string $id): JsonResponse
    {
        try {
            $this->galleryService->delete($id);

            return ApiResponse::success(
                null,
                'Gallery deleted successfully'
            );
        } catch (ModelNotFoundException) {
            return ApiResponse::error(
                'Gallery not found',
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to delete gallery: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
