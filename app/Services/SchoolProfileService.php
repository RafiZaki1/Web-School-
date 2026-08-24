<?php

namespace App\Services;

use App\Contracts\FileUploadServiceInterface;
use App\Contracts\SchoolProfileServiceInterface;
use App\Models\SchoolProfile;
use Illuminate\Http\UploadedFile;

class SchoolProfileService implements SchoolProfileServiceInterface
{
    public function __construct(
        protected FileUploadServiceInterface $fileUploadService
    ) {}

    /**
     * Get single school profile record.
     */
    public function getProfile(): ?SchoolProfile
    {
        return SchoolProfile::first();
    }

    /**
     * Update or create the single school profile.
     */
    public function updateProfile(array $data): SchoolProfile
    {
        $profile = SchoolProfile::first();

        // Handle school_logo upload
        if (isset($data['school_logo']) && $data['school_logo'] instanceof UploadedFile) {
            $data['school_logo'] = $this->fileUploadService->replace(
                $data['school_logo'],
                $profile?->school_logo,
                'school-profiles'
            );
        }

        // Handle principal_photo upload
        if (isset($data['principal_photo']) && $data['principal_photo'] instanceof UploadedFile) {
            $data['principal_photo'] = $this->fileUploadService->replace(
                $data['principal_photo'],
                $profile?->principal_photo,
                'school-profiles'
            );
        }

        // Handle background_image upload
        if (isset($data['background_image']) && $data['background_image'] instanceof UploadedFile) {
            $data['background_image'] = $this->fileUploadService->replace(
                $data['background_image'],
                $profile?->background_image,
                'school-profiles'
            );
        }

        if ($profile) {
            $profile->update($data);
            return $profile;
        }

        return SchoolProfile::create($data);
    }
}
