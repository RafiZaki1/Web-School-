<?php

namespace App\Services;

use App\Contracts\GalleryServiceInterface;
use App\Contracts\HeroServiceInterface;
use App\Contracts\HomeServiceInterface;
use App\Contracts\SchoolProfileServiceInterface;
use App\Contracts\StatisticServiceInterface;

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
