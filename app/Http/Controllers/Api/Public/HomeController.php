<?php

namespace App\Http\Controllers\Api\Public;

use App\Contracts\Interfaces\HomeServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\HomeResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class HomeController extends Controller
{
    public function __construct(
        protected HomeServiceInterface $homeService
    ) {}

    /**
     * Get all landing page data combined.
     */
    public function index(): JsonResponse
    {
        try {
            $homeData = $this->homeService->getHomeData();

            return ApiResponse::success(
                new HomeResource($homeData),
                'Home data retrieved successfully'
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve home data: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
