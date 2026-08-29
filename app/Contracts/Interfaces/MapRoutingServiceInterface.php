<?php

namespace App\Contracts\Interfaces;

interface MapRoutingServiceInterface
{
    /**
     * Calculate route from origin room to destination room.
     *
     * @param int|string $fromIdentifier Room ID or slug
     * @param int|string $toIdentifier Room ID or slug
     * @return array
     */
    public function calculateRoute(int|string $fromIdentifier, int|string $toIdentifier): array;
}
