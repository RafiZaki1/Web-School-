<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'building_name' => $this->building_name,
            'description' => $this->description,
            'image' => $this->formatImageUrl($this->image),
            'open_hours' => $this->open_hours,
            'is_active' => (bool) $this->is_active,
        ];
    }

    /**
     * Format full image URL.
     */
    protected function formatImageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return url(Storage::url($path));
    }
}
