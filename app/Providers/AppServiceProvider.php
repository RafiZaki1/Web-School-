<?php

namespace App\Providers;

use App\Contracts\Interfaces\FileUploadServiceInterface;
use App\Contracts\Interfaces\GalleryServiceInterface;
use App\Contracts\Interfaces\HeroServiceInterface;
use App\Contracts\Interfaces\HomeServiceInterface;
use App\Contracts\Interfaces\HeroRepositoryInterface;
use App\Contracts\Interfaces\SchoolProfileServiceInterface;
use App\Contracts\Interfaces\GalleryRepositoryInterface;
use App\Contracts\Interfaces\RoomRepositoryInterface;
use App\Contracts\Interfaces\RoomServiceInterface;
use App\Contracts\Interfaces\SchoolProfileRepositoryInterface;
use App\Contracts\Interfaces\StatisticServiceInterface;
use App\Contracts\Interfaces\StatisticRepositoryInterface;
use App\Contracts\Repositories\GalleryRepository;
use App\Contracts\Repositories\HeroRepository;
use App\Contracts\Repositories\RoomRepository;
use App\Contracts\Repositories\SchoolProfileRepository;
use App\Contracts\Repositories\StatisticRepository;
use App\Services\landingpageservices\FileUploadService;
use App\Services\landingpageservices\GalleryService;
use App\Services\landingpageservices\HeroService;
use App\Services\landingpageservices\HomeService;
use App\Services\landingpageservices\RoomService;
use App\Services\landingpageservices\SchoolProfileService;
use App\Services\landingpageservices\StatisticService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private array $register = [
        HeroRepositoryInterface::class => HeroRepository::class,
        GalleryRepositoryInterface::class => GalleryRepository::class,
        RoomRepositoryInterface::class => RoomRepository::class,
        SchoolProfileRepositoryInterface::class => SchoolProfileRepository::class,
        StatisticRepositoryInterface::class => StatisticRepository::class,

        HeroServiceInterface::class => HeroService::class,
        GalleryServiceInterface::class => GalleryService::class,
        HomeServiceInterface::class => HomeService::class,
        RoomServiceInterface::class => RoomService::class,
        SchoolProfileServiceInterface::class => SchoolProfileService::class,
        StatisticServiceInterface::class => StatisticService::class,

        FileUploadServiceInterface::class => FileUploadService::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->register as $index => $value) {
            $this->app->bind($index, $value);
        }
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
