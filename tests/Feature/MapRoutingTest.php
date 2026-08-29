<?php

namespace Tests\Feature;

use App\Models\MapEdge;
use App\Models\MapNode;
use App\Models\Room;
use App\Models\RoomCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MapRoutingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup Graph:
        // Node 1 (Gerbang) <-> Node 2 (Lobi) <-> Node 3 (Persimpangan) <-> Node 4 (RPL)
        $this->node1 = MapNode::create(['name' => 'Gerbang', 'x' => 50.0, 'y' => 95.0, 'is_walkable' => true]);
        $this->node2 = MapNode::create(['name' => 'Lobi', 'x' => 50.0, 'y' => 80.0, 'is_walkable' => true]);
        $this->node3 = MapNode::create(['name' => 'Persimpangan', 'x' => 50.0, 'y' => 60.0, 'is_walkable' => true]);
        $this->node4 = MapNode::create(['name' => 'Gedung RPL', 'x' => 25.0, 'y' => 50.0, 'is_walkable' => true]);
        $this->node5 = MapNode::create(['name' => 'Pulau Terisolasi', 'x' => 10.0, 'y' => 10.0, 'is_walkable' => true]);

        MapEdge::create(['from_node_id' => $this->node1->id, 'to_node_id' => $this->node2->id, 'distance' => 25.0, 'is_walkable' => true]);
        MapEdge::create(['from_node_id' => $this->node2->id, 'to_node_id' => $this->node3->id, 'distance' => 30.0, 'is_walkable' => true]);
        MapEdge::create(['from_node_id' => $this->node3->id, 'to_node_id' => $this->node4->id, 'distance' => 35.0, 'is_walkable' => true]);

        $this->roomOrigin = Room::create([
            'name' => 'Pos Satpam',
            'slug' => 'pos-satpam',
            'map_node_id' => $this->node1->id,
            'map_x' => 50.0,
            'map_y' => 96.0,
            'map_width' => 4.0,
            'map_height' => 3.0,
            'is_active' => true,
        ]);

        $this->roomDest = Room::create([
            'name' => 'X RPL 1',
            'slug' => 'x-rpl-1',
            'map_node_id' => $this->node4->id,
            'map_x' => 24.0,
            'map_y' => 50.0,
            'map_width' => 6.0,
            'map_height' => 5.0,
            'is_active' => true,
        ]);

        $this->roomIsolated = Room::create([
            'name' => 'Ruang Terisolasi',
            'slug' => 'ruang-terisolasi',
            'map_node_id' => $this->node5->id,
            'is_active' => true,
        ]);

        $this->roomInactive = Room::create([
            'name' => 'Ruang Ditutup',
            'slug' => 'ruang-ditutup',
            'map_node_id' => $this->node2->id,
            'is_active' => false,
        ]);
    }

    public function test_can_calculate_route_between_two_rooms(): void
    {
        $response = $this->getJson('/api/v1/public/map/route?from=pos-satpam&to=x-rpl-1');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Rute perjalanan berhasil dihitung',
                'data' => [
                    'origin' => [
                        'name' => 'Pos Satpam',
                        'slug' => 'pos-satpam',
                    ],
                    'destination' => [
                        'name' => 'X RPL 1',
                        'slug' => 'x-rpl-1',
                    ],
                    'distance' => 90.0, // 25 + 30 + 35
                    'estimated_minutes' => 2, // ceil(90 / 1.2 / 60) = 2 min
                ],
            ])
            ->assertJsonStructure([
                'data' => [
                    'origin',
                    'destination',
                    'distance',
                    'estimated_minutes',
                    'path' => [
                        '*' => ['x', 'y'],
                    ],
                ],
            ]);

        $path = $response->json('data.path');
        $this->assertNotEmpty($path);
        // First point is origin room center or node
        $this->assertEquals(52.0, $path[0]['x']);
        $this->assertEquals(97.5, $path[0]['y']);
    }

    public function test_route_fails_when_origin_and_destination_are_same(): void
    {
        $response = $this->getJson('/api/v1/public/map/route?from=pos-satpam&to=pos-satpam');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['to']);
    }

    public function test_route_fails_when_room_not_found(): void
    {
        $response = $this->getJson('/api/v1/public/map/route?from=pos-satpam&to=ruang-gaib');

        $response->assertStatus(404);
    }

    public function test_route_fails_when_no_walkable_path_exists(): void
    {
        $response = $this->getJson('/api/v1/public/map/route?from=pos-satpam&to=ruang-terisolasi');

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_route_fails_when_room_is_inactive(): void
    {
        $response = $this->getJson('/api/v1/public/map/route?from=pos-satpam&to=ruang-ditutup');

        $response->assertStatus(400);
    }

    public function test_can_list_map_categories_and_nodes(): void
    {
        RoomCategory::create(['name' => 'Lab Komputer', 'slug' => 'lab-komputer', 'is_active' => true]);

        $catResponse = $this->getJson('/api/v1/public/map/categories');
        $catResponse->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Lab Komputer');

        $nodeResponse = $this->getJson('/api/v1/public/map/nodes');
        $nodeResponse->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }
}
