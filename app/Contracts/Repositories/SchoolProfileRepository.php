<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\SchoolProfileRepositoryInterface;
use App\Models\SchoolProfile;

class SchoolProfileRepository implements SchoolProfileRepositoryInterface
{
    public function first(): ?SchoolProfile
    {
        return SchoolProfile::query()->first();
    }

    public function updateOrCreate(?SchoolProfile $profile, array $data): SchoolProfile
    {
        if ($profile) {
            $profile->update($data);

            return $profile->refresh();
        }

        return SchoolProfile::query()->create($data);
    }
}
