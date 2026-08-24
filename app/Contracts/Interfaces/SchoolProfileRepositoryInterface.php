<?php

namespace App\Contracts\Interfaces;

use App\Models\SchoolProfile;

interface SchoolProfileRepositoryInterface
{
    public function first(): ?SchoolProfile;

    public function updateOrCreate(?SchoolProfile $profile, array $data): SchoolProfile;
}
