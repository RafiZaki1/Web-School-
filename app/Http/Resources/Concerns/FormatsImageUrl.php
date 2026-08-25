<?php

namespace App\Http\Resources\Concerns;

use Illuminate\Support\Facades\Storage;

/**
 * Shared helper for Resources that need to turn a stored file path
 * into a full public URL. Previously this exact method was copy-pasted
 * into GalleryResource, HeroResource, RoomResource, RoomDetailResource,
 * and SchoolProfileResource — now they all just `use` this trait.
 */
trait FormatsImageUrl
{
    /**
     * Format full image URL from a stored path.
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
