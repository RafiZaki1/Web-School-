<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\FormatsImageUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeroResource extends JsonResource
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
            'title' => $this->title,
            'school_name' => $this->school_name,
            'description' => $this->description,
            'background_image' => $this->formatImageUrl($this->background_image),
            'button_text' => $this->button_text,
            'button_url' => $this->button_url,
            'is_active' => (bool) $this->is_active,
            'sort_order' => (int) $this->sort_order,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
