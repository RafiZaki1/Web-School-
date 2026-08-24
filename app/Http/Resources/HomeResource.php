<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $hero = $this->resource['hero'] ?? null;
        $galleries = $this->resource['galleries'] ?? [];
        $schoolProfile = $this->resource['school_profile'] ?? null;
        $statistics = $this->resource['statistics'] ?? [];

        return [
            'hero' => $hero ? new HeroResource($hero) : null,
            'galleries' => GalleryResource::collection($galleries),
            'school_profile' => $schoolProfile ? new SchoolProfileResource($schoolProfile) : null,
            'statistics' => new StatisticResource($statistics),
        ];
    }
}
