<?php

namespace App\Contracts\Interfaces;

use App\Models\SchoolProfile;

interface SchoolProfileServiceInterface
{
    public function getProfile(): ?SchoolProfile;

    public function updateProfile(array $data): SchoolProfile;
}
