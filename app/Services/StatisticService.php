<?php

namespace App\Services;

use App\Contracts\StatisticServiceInterface;
use App\Models\SchoolProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StatisticService implements StatisticServiceInterface
{
    /**
     * Calculate and retrieve school statistics data.
     *
     * @return array
     */
    public function getStatistics(): array
    {
        $totalStudents = Schema::hasTable('students')
            ? DB::table('students')->count()
            : 0;

        $totalTeachers = Schema::hasTable('teachers')
            ? DB::table('teachers')->count()
            : 0;

        $totalMajors = Schema::hasTable('majors')
            ? DB::table('majors')->count()
            : 0;

        $totalAlumni = Schema::hasTable('alumni')
            ? DB::table('alumni')->count()
            : 0;

        $establishedYear = SchoolProfile::first()?->established_year;

        return [
            'total_students' => $totalStudents,
            'total_teachers' => $totalTeachers,
            'established_year' => $establishedYear,
            'total_majors' => $totalMajors,
            'total_alumni' => $totalAlumni,
        ];
    }
}
