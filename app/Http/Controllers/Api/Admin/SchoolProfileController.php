<?php

namespace App\Http\Controllers\Api\Admin;

use App\Contracts\Interfaces\SchoolProfileServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolProfile\UpdateSchoolProfileRequest;
use App\Http\Resources\SchoolProfileResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class SchoolProfileController extends Controller
{
    public function __construct(
        protected SchoolProfileServiceInterface $schoolProfileService
    ) {}

    /**
     * Display the school profile.
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

    /**
     * Update or create the school profile.
     */
    public function update(UpdateSchoolProfileRequest $request): JsonResponse
    {
        try {
            $profile = $this->schoolProfileService->updateProfile($request->validated());

            return ApiResponse::success(
                new SchoolProfileResource($profile),
                'School profile updated successfully'
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to update school profile: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
