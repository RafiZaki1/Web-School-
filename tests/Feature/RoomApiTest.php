<?php

namespace Tests\Feature;

use App\Models\Facility;
use App\Models\Room;
use App\Models\RoomCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_all_active_rooms_with_hotspot_and_category(): void
    {
        $category = RoomCategory::create([
            'name' => 'Lab Komputer',
            'slug' => 'lab-komputer',
            'is_active' => true,
        ]);

        Room::create([
            'name' => 'Laboratorium RPL',
            'slug' => 'laboratorium-rpl',
            'building_name' => 'Gedung RPL',
            'category_id' => $category->id,
            'map_x' => 55.2,
            'map_y' => 22.8,
            'map_width' => 7.4,
            'map_height' => 5.2,
            'is_active' => true,
        ]);
        Room::create([
            'name' => 'Perpustakaan',
            'slug' => 'perpustakaan',
            'building_name' => 'Gedung Utama',
            'is_active' => true,
        ]);
        Room::create([
            'name' => 'Ruang Rahasia',
            'slug' => 'ruang-rahasia',
            'is_active' => false,
        ]);

        $response = $this->getJson('/api/v1/public/rooms');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Rooms retrieved successfully',
            ])
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.name', 'Laboratorium RPL')
            ->assertJsonPath('data.0.category.name', 'Lab Komputer')
            ->assertJsonPath('data.0.hotspot.x', 55.2)
            ->assertJsonPath('data.0.hotspot.y', 22.8)
            ->assertJsonPath('data.1.name', 'Perpustakaan');
    }

    public function test_can_search_rooms_by_name_slug_or_category(): void
    {
        $catLab = RoomCategory::create(['name' => 'Laboratorium', 'slug' => 'lab']);
        $catClass = RoomCategory::create(['name' => 'Kelas', 'slug' => 'kelas']);

        Room::create([
            'name' => 'X RPL 1',
            'slug' => 'x-rpl-1',
            'building_name' => 'Gedung Barat',
            'category_id' => $catClass->id,
            'is_active' => true,
        ]);
        Room::create([
            'name' => 'Lab RPL',
            'slug' => 'lab-rpl',
            'building_name' => 'Gedung Barat',
            'category_id' => $catLab->id,
            'is_active' => true,
        ]);
        Room::create([
            'name' => 'Kantin',
            'slug' => 'kantin',
            'building_name' => 'Area Belakang',
            'is_active' => true,
        ]);

        // Search by keyword "RPL"
        $response = $this->getJson('/api/v1/public/rooms/search?q=RPL');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.name', 'X RPL 1')
            ->assertJsonPath('data.1.name', 'Lab RPL');

        // Search by category keyword "Laboratorium"
        $responseCat = $this->getJson('/api/v1/public/rooms/search?q=Laboratorium');
        $responseCat->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Lab RPL');

        // Validation error on empty query
        $responseEmpty = $this->getJson('/api/v1/public/rooms/search?q=');
        $responseEmpty->assertStatus(422);
    }

    public function test_can_get_room_detail_by_id_or_slug(): void
    {
        $room = Room::create([
            'name' => 'Laboratorium RPL',
            'slug' => 'laboratorium-rpl',
            'building_name' => 'Gedung RPL',
            'description' => 'Laboratorium praktik untuk siswa RPL',
            'open_hours' => '07:00 - 16:00 WIB',
            'map_x' => 10.5,
            'map_y' => 20.5,
            'map_width' => 5.0,
            'map_height' => 4.0,
            'is_active' => true,
        ]);

        // By ID
        $responseById = $this->getJson("/api/v1/public/rooms/{$room->id}");
        $responseById->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Room detail retrieved successfully',
                'data' => [
                    'id' => $room->id,
                    'name' => 'Laboratorium RPL',
                    'slug' => 'laboratorium-rpl',
                    'building_name' => 'Gedung RPL',
                    'description' => 'Laboratorium praktik untuk siswa RPL',
                    'open_hours' => '07:00 - 16:00 WIB',
                    'hotspot' => [
                        'x' => 10.5,
                        'y' => 20.5,
                        'width' => 5.0,
                        'height' => 4.0,
                    ],
                ],
            ]);

        // By Slug
        $responseBySlug = $this->getJson("/api/v1/public/rooms/laboratorium-rpl");
        $responseBySlug->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $room->id,
                    'name' => 'Laboratorium RPL',
                ],
            ]);
    }

    public function test_can_get_facilities_belonging_only_to_selected_room(): void
    {
        $room1 = Room::create([
            'name' => 'Laboratorium RPL',
            'slug' => 'laboratorium-rpl',
            'is_active' => true,
        ]);
        $room2 = Room::create([
            'name' => 'Perpustakaan',
            'slug' => 'perpustakaan',
            'is_active' => true,
        ]);

        Facility::create([
            'room_id' => $room1->id,
            'name' => 'Komputer Siswa',
            'icon' => 'computer',
            'quantity' => 36,
            'description' => 'PC i7',
        ]);
        Facility::create([
            'room_id' => $room1->id,
            'name' => 'Proyektor',
            'icon' => 'projector',
            'quantity' => 1,
            'description' => 'Epson',
        ]);

        Facility::create([
            'room_id' => $room2->id,
            'name' => 'Rak Buku',
            'icon' => 'bookshelf',
            'quantity' => 10,
            'description' => 'Rak besi',
        ]);

        $response = $this->getJson("/api/v1/public/rooms/{$room1->id}/facilities");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Facilities retrieved successfully',
            ])
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.name', 'Komputer Siswa')
            ->assertJsonPath('data.1.name', 'Proyektor');

        // Verify room 2 facilities
        $responseRoom2 = $this->getJson("/api/v1/public/rooms/perpustakaan/facilities");
        $responseRoom2->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Rak Buku');
    }

    public function test_returns_404_when_room_not_found(): void
    {
        $response = $this->getJson('/api/v1/public/rooms/9999');
        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Room not found',
            ]);

        $responseFacilities = $this->getJson('/api/v1/public/rooms/non-existent-room/facilities');
        $responseFacilities->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Room not found',
            ]);
    }
}
