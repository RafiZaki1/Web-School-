<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\Hero;
use App\Models\SchoolProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_retrieve_aggregated_home_data(): void
    {
        Hero::create([
            'title' => 'Main Hero',
            'school_name' => 'JHIC School',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Gallery::create([
            'title' => 'Gallery 1',
            'image' => 'galleries/1.jpg',
            'category' => 'Kegiatan',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        SchoolProfile::create([
            'school_name' => 'JHIC School',
            'welcome_message' => 'Welcome message',
            'established_year' => 2014,
        ]);

        $response = $this->getJson('/api/v1/public/home');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Home data retrieved successfully',
                'data' => [
                    'hero' => [
                        'title' => 'Main Hero',
                    ],
                    'galleries' => [
                        [
                            'title' => 'Gallery 1',
                        ],
                    ],
                    'school_profile' => [
                        'school_name' => 'JHIC School',
                    ],
                    'statistics' => [
                        'established_year' => 2014,
                    ],
                ],
            ]);
    }
}
