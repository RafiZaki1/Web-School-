<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\FormatsImageUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    use FormatsImageUrl;

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
}
