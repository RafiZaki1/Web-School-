<?php

namespace App\Services\LandingPage;

use App\Contracts\Interfaces\GalleryServiceInterface;
use App\Contracts\Interfaces\HeroServiceInterface;
use App\Contracts\Interfaces\HomeServiceInterface;
use App\Contracts\Interfaces\SchoolProfileServiceInterface;
use App\Contracts\Interfaces\StatisticServiceInterface;

class HomeService implements HomeServiceInterface
{
    public function __construct(
        protected HeroServiceInterface $heroService,
        protected GalleryServiceInterface $galleryService,
        protected SchoolProfileServiceInterface $schoolProfileService,
        protected StatisticServiceInterface $statisticService
    ) {}

    /**
     * Get aggregated data for Landing Page.
     *
     * @return array
     */
    public function getHomeData(): array
    {
        return [
            'hero' => $this->heroService->getActiveHero(),
            'galleries' => $this->galleryService->getActiveGalleries(),
            'school_profile' => $this->schoolProfileService->getProfile(),
            'statistics' => $this->statisticService->getStatistics(),
        ];
    }
}
