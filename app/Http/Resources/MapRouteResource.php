<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MapRouteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'origin' => [
                'id' => data_get($this->resource, 'origin.id'),
                'name' => data_get($this->resource, 'origin.name'),
                'slug' => data_get($this->resource, 'origin.slug'),
            ],
            'destination' => [
                'id' => data_get($this->resource, 'destination.id'),
                'name' => data_get($this->resource, 'destination.name'),
                'slug' => data_get($this->resource, 'destination.slug'),
            ],
            'distance' => (float) data_get($this->resource, 'distance', 0),
            'estimated_minutes' => (int) data_get($this->resource, 'estimated_minutes', 0),
            'path' => data_get($this->resource, 'path', []),
        ];
    }
}
