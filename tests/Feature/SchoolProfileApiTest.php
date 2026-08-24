<?php

namespace Tests\Feature;

use App\Models\SchoolProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Tests\TestCase;

class SchoolProfileApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->actingAs(User::factory()->create());
    }

    public function test_can_get_school_profile(): void
    {
        SchoolProfile::create([
            'school_name' => 'JHIC School',
            'principal_name' => 'Dr. H. Ahmad',
            'established_year' => 2014,
        ]);

        $response = $this->getJson('/api/v1/admin/school-profile');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'school_name' => 'JHIC School',
                    'principal_name' => 'Dr. H. Ahmad',
                    'established_year' => 2014,
                ],
            ]);
    }

    public function test_can_update_or_create_school_profile_with_uploads(): void
    {
        $logo = UploadedFile::fake()->image('logo.png');
        $photo = UploadedFile::fake()->image('principal.jpg');
        $bg = UploadedFile::fake()->image('bg.webp');

        $payload = [
            'school_name' => 'Jakarta Honors International College',
            'principal_name' => 'Dr. John Doe, M.Ed',
            'principal_position' => 'Kepala Sekolah',
            'welcome_message' => 'Selamat datang di website resmi JHIC.',
            'established_year' => 2014,
            'school_logo' => $logo,
            'principal_photo' => $photo,
            'background_image' => $bg,
        ];

        $response = $this->postJson('/api/v1/admin/school-profile', $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'School profile updated successfully',
                'data' => [
                    'school_name' => 'Jakarta Honors International College',
                    'established_year' => 2014,
                ],
            ]);

        $this->assertDatabaseCount('school_profiles', 1);
        $profile = SchoolProfile::first();
        Storage::disk('public')->assertExists($profile->school_logo);
        Storage::disk('public')->assertExists($profile->principal_photo);
        Storage::disk('public')->assertExists($profile->background_image);
    }

    public function test_public_school_profile_endpoint(): void
    {
        SchoolProfile::create([
            'school_name' => 'JHIC Public Profile',
            'established_year' => 2014,
        ]);

        $response = $this->getJson('/api/v1/public/school-profile');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'school_name' => 'JHIC Public Profile',
                ],
            ]);
    }
}
