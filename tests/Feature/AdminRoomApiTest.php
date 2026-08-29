<?php

namespace Tests\Feature;

use App\Models\Facility;
use App\Models\MapEdge;
use App\Models\MapNode;
use App\Models\Room;
use App\Models\RoomCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminRoomApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->user = User::factory()->create();
    }

    public function test_unauthenticated_user_cannot_access_admin_rooms(): void
    {
        $response = $this->getJson('/api/v1/admin/rooms');
        $response->assertStatus(401);
    }

    public function test_admin_can_list_all_rooms_including_inactive(): void
    {
        $this->actingAs($this->user);

        Room::create(['name' => 'Room 1', 'slug' => 'room-1', 'is_active' => true]);
        Room::create(['name' => 'Room 2', 'slug' => 'room-2', 'is_active' => false]);

        $response = $this->getJson('/api/v1/admin/rooms');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function test_admin_can_create_room_with_coordinates_and_image(): void
    {
        $this->actingAs($this->user);

        $category = RoomCategory::create(['name' => 'Kelas', 'slug' => 'kelas']);
        $node = MapNode::create(['name' => 'Node 1', 'x' => 20.0, 'y' => 30.0]);
        $file = UploadedFile::fake()->image('room.jpg');

        $payload = [
            'name' => 'X RPL 1',
            'slug' => 'x-rpl-1',
            'building_name' => 'Gedung Barat',
            'category_id' => $category->id,
            'description' => 'Kelas X RPL 1',
            'open_hours' => '07:00 - 15:00',
            'is_active' => true,
            'map_x' => 25.5,
            'map_y' => 35.5,
            'map_width' => 6.0,
            'map_height' => 4.0,
            'map_node_id' => $node->id,
            'image' => $file,
        ];

        $response = $this->postJson('/api/v1/admin/rooms', $payload);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'X RPL 1')
            ->assertJsonPath('data.hotspot.x', 25.5)
            ->assertJsonPath('data.hotspot.y', 35.5);

        $this->assertDatabaseHas('rooms', [
            'slug' => 'x-rpl-1',
            'category_id' => $category->id,
        ]);
    }

    public function test_admin_can_update_room(): void
    {
        $this->actingAs($this->user);

        $room = Room::create([
            'name' => 'Old Room Name',
            'slug' => 'old-room-name',
            'is_active' => true,
        ]);

        $response = $this->putJson("/api/v1/admin/rooms/{$room->id}", [
            'name' => 'Updated Room Name',
            'map_x' => 40.0,
            'map_y' => 50.0,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'Updated Room Name');

        $this->assertEquals(40.0, (float) $response->json('data.hotspot.x'));

        $this->assertDatabaseHas('rooms', [
            'id' => $room->id,
            'name' => 'Updated Room Name',
        ]);
    }

    public function test_admin_can_delete_room(): void
    {
        $this->actingAs($this->user);

        $room = Room::create(['name' => 'To Delete', 'slug' => 'to-delete']);

        $response = $this->deleteJson("/api/v1/admin/rooms/{$room->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('rooms', ['id' => $room->id]);
    }

    public function test_admin_can_manage_facilities_in_room(): void
    {
        $this->actingAs($this->user);

        $room = Room::create(['name' => 'Lab RPL', 'slug' => 'lab-rpl']);

        // 1. Create Facility
        $createRes = $this->postJson("/api/v1/admin/rooms/{$room->id}/facilities", [
            'name' => 'PC Gaming Core i9',
            'icon' => 'computer',
            'quantity' => 36,
            'description' => 'Spesifikasi tinggi',
        ]);

        $createRes->assertStatus(201)
            ->assertJsonPath('data.name', 'PC Gaming Core i9');

        $facilityId = $createRes->json('data.id');

        // 2. List Facilities
        $listRes = $this->getJson("/api/v1/admin/rooms/{$room->id}/facilities");
        $listRes->assertStatus(200)->assertJsonCount(1, 'data');

        // 3. Update Facility
        $updateRes = $this->putJson("/api/v1/admin/rooms/{$room->id}/facilities/{$facilityId}", [
            'name' => 'PC Gaming Updated',
            'quantity' => 40,
        ]);
        $updateRes->assertStatus(200)
            ->assertJsonPath('data.name', 'PC Gaming Updated');

        // 4. Delete Facility
        $deleteRes = $this->deleteJson("/api/v1/admin/rooms/{$room->id}/facilities/{$facilityId}");
        $deleteRes->assertStatus(200);

        $this->assertDatabaseMissing('facilities', ['id' => $facilityId]);
    }

    public function test_admin_can_manage_map_nodes_and_edges(): void
    {
        $this->actingAs($this->user);

        // 1. Node CRUD
        $nodeRes1 = $this->postJson('/api/v1/admin/map/nodes', [
            'name' => 'Waypoint Alpha',
            'x' => 12.5,
            'y' => 34.5,
            'is_walkable' => true,
        ]);
        $nodeRes1->assertStatus(201);
        $nodeId1 = $nodeRes1->json('data.id');

        $nodeRes2 = $this->postJson('/api/v1/admin/map/nodes', [
            'name' => 'Waypoint Beta',
            'x' => 20.0,
            'y' => 40.0,
            'is_walkable' => true,
        ]);
        $nodeId2 = $nodeRes2->json('data.id');

        // 2. Edge CRUD
        $edgeRes = $this->postJson('/api/v1/admin/map/edges', [
            'from_node_id' => $nodeId1,
            'to_node_id' => $nodeId2,
            'distance' => 15.5,
            'is_walkable' => true,
        ]);
        $edgeRes->assertStatus(201)
            ->assertJsonPath('data.distance', 15.5);

        $edgeId = $edgeRes->json('data.id');

        $this->assertDatabaseHas('map_edges', ['id' => $edgeId]);
    }

    public function test_admin_can_manage_room_categories(): void
    {
        $this->actingAs($this->user);

        $res = $this->postJson('/api/v1/admin/room-categories', [
            'name' => 'Laboratorium Khusus',
            'slug' => 'lab-khusus',
            'icon' => 'flask',
        ]);
        $res->assertStatus(201)
            ->assertJsonPath('data.name', 'Laboratorium Khusus');

        $catId = $res->json('data.id');

        $updateRes = $this->putJson("/api/v1/admin/room-categories/{$catId}", [
            'name' => 'Laboratorium Sangat Khusus',
        ]);
        $updateRes->assertStatus(200)
            ->assertJsonPath('data.name', 'Laboratorium Sangat Khusus');

        $deleteRes = $this->deleteJson("/api/v1/admin/room-categories/{$catId}");
        $deleteRes->assertStatus(200);

        $this->assertDatabaseMissing('room_categories', ['id' => $catId]);
    }
}
