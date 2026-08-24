<?php

namespace App\Http\Controllers\Api\Public;

use App\Contracts\HeroServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\HeroResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class HeroPublicController extends Controller
{
    public function __construct(
        protected HeroServiceInterface $heroService
    ) {}

    /**
     * Display a listing of active heroes for public.
     */
    public function index(): JsonResponse
    {
        try {
            $heroes = $this->heroService->getActiveHeroes();

            return ApiResponse::success(
                HeroResource::collection($heroes),
                'Active heroes retrieved successfully'
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Failed to retrieve active heroes: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
