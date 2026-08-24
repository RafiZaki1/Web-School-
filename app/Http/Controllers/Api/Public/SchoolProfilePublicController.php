<?php

namespace App\Http\Controllers\Api\Public;

use App\Contracts\SchoolProfileServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolProfileResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class SchoolProfilePublicController extends Controller
{
    public function __construct(
        protected SchoolProfileServiceInterface $schoolProfileService
    ) {}

    /**
     * Display school profile for public.
     */
    public function show(): JsonResponse
    {
        try {
            $profile = $this->schoolProfileService->getProfile();

            return ApiResponse::success(
                $profile ? new SchoolProfileResource($profile) : null,
                'School profile retrieved successfully'
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve school profile: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
