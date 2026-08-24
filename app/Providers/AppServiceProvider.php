<?php

namespace App\Providers;

use App\Contracts\FileUploadServiceInterface;
use App\Contracts\GalleryServiceInterface;
use App\Contracts\HeroServiceInterface;
use App\Contracts\HomeServiceInterface;
use App\Contracts\SchoolProfileServiceInterface;
use App\Contracts\StatisticServiceInterface;
use App\Services\FileUploadService;
use App\Services\GalleryService;
use App\Services\HeroService;
use App\Services\HomeService;
use App\Services\SchoolProfileService;
use App\Services\StatisticService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FileUploadServiceInterface::class, FileUploadService::class);
        $this->app->bind(HeroServiceInterface::class, HeroService::class);
        $this->app->bind(GalleryServiceInterface::class, GalleryService::class);
        $this->app->bind(SchoolProfileServiceInterface::class, SchoolProfileService::class);
        $this->app->bind(StatisticServiceInterface::class, StatisticService::class);
        $this->app->bind(HomeServiceInterface::class, HomeService::class);
        $this->app->bind(\App\Contracts\RoomServiceInterface::class, \App\Services\RoomService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
