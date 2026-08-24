<?php

namespace App\Http\Controllers\Api\Public;

use App\Contracts\Interfaces\GalleryServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class GalleryPublicController extends Controller
{
    public function __construct(
        protected GalleryServiceInterface $galleryService
    ) {}

    /**
     * Display a listing of active galleries for public, with optional category filter.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $galleries = $this->galleryService->getActiveGalleries($request->query('category'));

            return ApiResponse::success(
                GalleryResource::collection($galleries),
                'Active galleries retrieved successfully'
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve active galleries: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
