<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\StatisticRepositoryInterface;
use App\Models\SchoolProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StatisticRepository implements StatisticRepositoryInterface
{
    public function getCounts(): array
    {
        return [
            'total_students' => $this->countTable('students'),
            'total_teachers' => $this->countTable('teachers'),
            'total_majors' => $this->countTable('majors'),
            'total_alumni' => $this->countTable('alumni'),
        ];
    }

    public function establishedYear(): ?int
    {
        return SchoolProfile::query()->value('established_year');
    }

    private function countTable(string $table): int
    {
        return Schema::hasTable($table) ? DB::table($table)->count() : 0;
    }
}
