<?php

namespace Tests\Feature;

use App\Models\SchoolProfile;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StatisticsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_statistics_with_default_zeroes_when_subtables_not_present(): void
    {
        SchoolProfile::create([
            'school_name' => 'JHIC School',
            'established_year' => 2014,
        ]);

        $response = $this->getJson('/api/v1/public/statistics');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Statistics retrieved successfully',
                'data' => [
                    'total_students' => 0,
                    'total_teachers' => 0,
                    'established_year' => 2014,
                    'total_majors' => 0,
                    'total_alumni' => 0,
                ],
            ]);
    }

    public function test_counts_dynamic_tables_when_they_exist(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        DB::table('students')->insert([['name' => 'Student 1'], ['name' => 'Student 2']]);
        DB::table('teachers')->insert([['name' => 'Teacher 1']]);
        DB::table('majors')->insert([['name' => 'Major 1'], ['name' => 'Major 2'], ['name' => 'Major 3']]);
        DB::table('alumni')->insert([['name' => 'Alumni 1'], ['name' => 'Alumni 2']]);

        SchoolProfile::create([
            'school_name' => 'JHIC School',
            'established_year' => 2014,
        ]);

        $response = $this->getJson('/api/v1/public/statistics');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'total_students' => 2,
                    'total_teachers' => 1,
                    'established_year' => 2014,
                    'total_majors' => 3,
                    'total_alumni' => 2,
                ],
            ]);
    }
}
