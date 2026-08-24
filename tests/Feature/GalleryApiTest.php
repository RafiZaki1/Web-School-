<?php

namespace Tests\Feature;

use App\Models\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Tests\TestCase;

class GalleryApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->actingAs(User::factory()->create());
    }

    public function test_can_list_all_galleries_and_filter_by_category(): void
    {
        Gallery::create([
            'title' => 'Kegiatan Pramuka',
            'image' => 'galleries/pramuka.jpg',
            'category' => 'Kegiatan',
            'is_active' => true,
            'sort_order' => 1,
        ]);
        Gallery::create([
            'title' => 'Laboratorium Komputer',
            'image' => 'galleries/lab.jpg',
            'category' => 'Fasilitas',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $responseAll = $this->getJson('/api/v1/admin/galleries');
        $responseAll->assertStatus(200)->assertJsonCount(2, 'data');

        $responseFiltered = $this->getJson('/api/v1/admin/galleries?category=Kegiatan');
        $responseFiltered->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Kegiatan Pramuka');
    }

    public function test_can_create_gallery_item_with_image(): void
    {
        $file = UploadedFile::fake()->image('activity.png');

        $payload = [
            'title' => 'Upacara Bendera',
            'category' => 'Kegiatan',
            'image' => $file,
            'is_active' => true,
            'sort_order' => 1,
        ];

        $response = $this->postJson('/api/v1/admin/galleries', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Gallery created successfully',
                'data' => [
                    'title' => 'Upacara Bendera',
                    'category' => 'Kegiatan',
                ],
            ]);

        $gallery = Gallery::first();
        $this->assertNotNull($gallery->image);
        Storage::disk('public')->assertExists($gallery->image);
    }

    public function test_can_update_gallery_and_replace_image(): void
    {
        $oldFile = UploadedFile::fake()->image('old_gallery.jpg');
        $oldPath = $oldFile->store('galleries', 'public');

        $gallery = Gallery::create([
            'title' => 'Old Title',
            'image' => $oldPath,
            'category' => 'Prestasi',
            'is_active' => true,
        ]);

        $newFile = UploadedFile::fake()->image('new_gallery.jpg');

        $response = $this->postJson("/api/v1/admin/galleries/{$gallery->id}", [
            '_method' => 'PUT',
            'title' => 'Updated Title',
            'image' => $newFile,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'title' => 'Updated Title',
                ],
            ]);

        Storage::disk('public')->assertMissing($oldPath);
        $gallery->refresh();
        Storage::disk('public')->assertExists($gallery->image);
    }

    public function test_can_delete_gallery_and_remove_image(): void
    {
        $file = UploadedFile::fake()->image('pic.jpg');
        $path = $file->store('galleries', 'public');

        $gallery = Gallery::create([
            'title' => 'Gallery to delete',
            'image' => $path,
            'is_active' => true,
        ]);

        $response = $this->deleteJson("/api/v1/admin/galleries/{$gallery->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Gallery deleted successfully',
            ]);

        $this->assertDatabaseMissing('galleries', ['id' => $gallery->id]);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_public_galleries_endpoint_only_returns_active(): void
    {
        Gallery::create([
            'title' => 'Active Gallery',
            'image' => 'galleries/1.jpg',
            'is_active' => true,
            'sort_order' => 1,
        ]);
        Gallery::create([
            'title' => 'Inactive Gallery',
            'image' => 'galleries/2.jpg',
            'is_active' => false,
            'sort_order' => 2,
        ]);

        $response = $this->getJson('/api/v1/public/galleries');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Active Gallery');
    }
}
