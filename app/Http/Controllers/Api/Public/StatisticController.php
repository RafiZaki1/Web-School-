<?php

namespace App\Http\Controllers\Api\Public;

use App\Contracts\StatisticServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\StatisticResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class StatisticController extends Controller
{
    public function __construct(
        protected StatisticServiceInterface $statisticService
    ) {}

    /**
     * Get school statistics.
     */
    public function index(): JsonResponse
    {
        try {
            $statistics = $this->statisticService->getStatistics();

            return ApiResponse::success(
                new StatisticResource($statistics),
                'Statistics retrieved successfully'
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve statistics: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
