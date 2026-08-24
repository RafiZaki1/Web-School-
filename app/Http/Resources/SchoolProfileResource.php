<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SchoolProfileResource extends JsonResource
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
            'school_name' => $this->school_name,
            'school_logo' => $this->formatImageUrl($this->school_logo),
            'principal_name' => $this->principal_name,
            'principal_position' => $this->principal_position,
            'principal_photo' => $this->formatImageUrl($this->principal_photo),
            'welcome_message' => $this->welcome_message,
            'background_image' => $this->formatImageUrl($this->background_image),
            'established_year' => $this->established_year ? (int) $this->established_year : null,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
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
