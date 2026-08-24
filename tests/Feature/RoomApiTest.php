<?php

namespace Tests\Feature;

use App\Models\Facility;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_all_active_rooms(): void
    {
        Room::create([
            'name' => 'Laboratorium RPL',
            'slug' => 'laboratorium-rpl',
            'building_name' => 'Gedung RPL',
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
            ->assertJsonPath('data.1.name', 'Perpustakaan');
    }

    public function test_can_get_room_detail_by_id_or_slug(): void
    {
        $room = Room::create([
            'name' => 'Laboratorium RPL',
            'slug' => 'laboratorium-rpl',
            'building_name' => 'Gedung RPL',
            'description' => 'Laboratorium praktik untuk siswa RPL',
            'open_hours' => '07:00 - 16:00 WIB',
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
