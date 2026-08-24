<?php

namespace Tests\Feature;

use App\Models\Hero;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Tests\TestCase;

class HeroApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->actingAs(User::factory()->create());
    }

    public function test_can_list_all_heroes_for_admin(): void
    {
        Hero::create([
            'title' => 'Hero 1',
            'school_name' => 'JHIC School',
            'is_active' => true,
            'sort_order' => 1,
        ]);
        Hero::create([
            'title' => 'Hero 2',
            'school_name' => 'JHIC School',
            'is_active' => false,
            'sort_order' => 2,
        ]);

        $response = $this->getJson('/api/v1/admin/heroes');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Heroes retrieved successfully',
            ])
            ->assertJsonCount(2, 'data');
    }

    public function test_can_create_hero_with_image_upload(): void
    {
        $file = UploadedFile::fake()->image('banner.jpg');

        $payload = [
            'title' => 'Welcome to JHIC',
            'school_name' => 'Jakarta Honors International College',
            'description' => 'A premier school for future leaders.',
            'button_text' => 'Enroll Now',
            'button_url' => 'https://jhic.sch.id/enroll',
            'background_image' => $file,
            'is_active' => true,
            'sort_order' => 1,
        ];

        $response = $this->postJson('/api/v1/admin/heroes', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Hero created successfully',
                'data' => [
                    'title' => 'Welcome to JHIC',
                    'school_name' => 'Jakarta Honors International College',
                    'is_active' => true,
                ],
            ]);

        $this->assertDatabaseHas('heroes', [
            'title' => 'Welcome to JHIC',
        ]);

        $hero = Hero::first();
        $this->assertNotNull($hero->background_image);
        Storage::disk('public')->assertExists($hero->background_image);
    }

    public function test_can_show_hero_detail(): void
    {
        $hero = Hero::create([
            'title' => 'Hero Detail',
            'school_name' => 'JHIC School',
            'is_active' => true,
        ]);

        $response = $this->getJson("/api/v1/admin/heroes/{$hero->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $hero->id,
                    'title' => 'Hero Detail',
                ],
            ]);
    }

    public function test_can_update_hero_and_replace_image(): void
    {
        $oldFile = UploadedFile::fake()->image('old.jpg');
        $oldPath = $oldFile->store('heroes', 'public');

        $hero = Hero::create([
            'title' => 'Old Title',
            'school_name' => 'JHIC',
            'background_image' => $oldPath,
            'is_active' => true,
        ]);

        $newFile = UploadedFile::fake()->image('new.jpg');

        $response = $this->postJson("/api/v1/admin/heroes/{$hero->id}", [
            '_method' => 'PUT',
            'title' => 'Updated Title',
            'background_image' => $newFile,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'title' => 'Updated Title',
                ],
            ]);

        Storage::disk('public')->assertMissing($oldPath);
        $hero->refresh();
        Storage::disk('public')->assertExists($hero->background_image);
    }

    public function test_can_delete_hero_and_remove_image(): void
    {
        $file = UploadedFile::fake()->image('banner.jpg');
        $path = $file->store('heroes', 'public');

        $hero = Hero::create([
            'title' => 'Hero to delete',
            'school_name' => 'JHIC',
            'background_image' => $path,
            'is_active' => true,
        ]);

        $response = $this->deleteJson("/api/v1/admin/heroes/{$hero->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Hero deleted successfully',
            ]);

        $this->assertDatabaseMissing('heroes', ['id' => $hero->id]);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_public_heroes_endpoint_only_returns_active(): void
    {
        Hero::create([
            'title' => 'Active Hero',
            'school_name' => 'JHIC School',
            'is_active' => true,
            'sort_order' => 1,
        ]);
        Hero::create([
            'title' => 'Inactive Hero',
            'school_name' => 'JHIC School',
            'is_active' => false,
            'sort_order' => 2,
        ]);

        $response = $this->getJson('/api/v1/public/heroes');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Active Hero');
    }
}
