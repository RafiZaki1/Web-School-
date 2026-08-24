<?php

namespace App\Services\landingpageservices;

use App\Contracts\Interfaces\StatisticServiceInterface;
use App\Contracts\Interfaces\StatisticRepositoryInterface;

class StatisticService implements StatisticServiceInterface
{
    public function __construct(
        protected StatisticRepositoryInterface $statisticRepository,
    ) {}

    /**
     * Calculate and retrieve school statistics data.
     *
     * @return array
     */
    public function getStatistics(): array
    {
        $counts = $this->statisticRepository->getCounts();

        return [
            ...$counts,
            'established_year' => $this->statisticRepository->establishedYear(),
        ];
    }
}
