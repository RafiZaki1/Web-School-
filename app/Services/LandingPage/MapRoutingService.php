<?php

namespace App\Services\LandingPage;

use App\Contracts\Interfaces\MapRepositoryInterface;
use App\Contracts\Interfaces\MapRoutingServiceInterface;
use App\Contracts\Interfaces\RoomRepositoryInterface;
use App\Models\MapNode;
use App\Models\Room;
use InvalidArgumentException;
use RuntimeException;

class MapRoutingService implements MapRoutingServiceInterface
{
    /**
     * Walking speed in meters per second (default standard walking speed ~ 1.2 m/s).
     */
    protected float $walkingSpeed = 1.2;

    public function __construct(
        protected RoomRepositoryInterface $roomRepository,
        protected MapRepositoryInterface $mapRepository,
    ) {}

    /**
     * Calculate shortest path from origin room to destination room.
     */
    public function calculateRoute(int|string $fromIdentifier, int|string $toIdentifier): array
    {
        $origin = $this->roomRepository->findByIdentifierOrFail($fromIdentifier);
        $destination = $this->roomRepository->findByIdentifierOrFail($toIdentifier);

        if (!$origin->is_active || !$destination->is_active) {
            throw new RuntimeException('Salah satu ruangan tujuan atau asal tidak aktif.');
        }

        if ($origin->id === $destination->id) {
            throw new InvalidArgumentException('Lokasi asal dan tujuan tidak boleh sama.');
        }

        // 1. Resolve start node and end node
        $startNodeId = $this->resolveRoomNodeId($origin);
        $endNodeId = $this->resolveRoomNodeId($destination);

        if (!$startNodeId || !$endNodeId) {
            throw new RuntimeException('Koordinat waypoint untuk salah satu ruangan belum ditentukan pada denah.');
        }

        // 2. Load all walkable nodes and edges
        $nodes = $this->mapRepository->getWalkableNodes()->keyBy('id');
        $edges = $this->mapRepository->getWalkableEdges();

        if ($nodes->isEmpty() || $edges->isEmpty()) {
            throw new RuntimeException('Data jalur pejalan kaki (waypoint/edges) belum tersedia.');
        }

        // 3. Build adjacency graph (bidirectional walkways)
        $graph = [];
        foreach ($nodes as $nodeId => $node) {
            $graph[$nodeId] = [];
        }

        foreach ($edges as $edge) {
            $from = $edge->from_node_id;
            $to = $edge->to_node_id;
            $dist = (float) $edge->distance;

            if (isset($graph[$from]) && isset($graph[$to])) {
                $graph[$from][$to] = $dist;
                $graph[$to][$from] = $dist; // Bidirectional jalur denah
            }
        }

        // 4. Dijkstra Shortest Path Algorithm
        $shortest = $this->dijkstra($graph, $startNodeId, $endNodeId);

        if ($shortest === null) {
            throw new RuntimeException('Tidak ditemukan jalur pejalan kaki yang terhubung antara kedua ruangan tersebut.');
        }

        $nodePath = $shortest['path'];
        $totalDistance = (float) $shortest['distance'];

        // 5. Construct coordinates path for Frontend SVG rendering
        $pathCoordinates = [];

        // Add origin room hotspot center if available
        if ($origin->map_x !== null && $origin->map_y !== null) {
            $pathCoordinates[] = [
                'x' => round((float) $origin->map_x + ((float) ($origin->map_width ?? 0) / 2), 2),
                'y' => round((float) $origin->map_y + ((float) ($origin->map_height ?? 0) / 2), 2),
            ];
        }

        // Add waypoints
        foreach ($nodePath as $nId) {
            if (isset($nodes[$nId])) {
                $pathCoordinates[] = [
                    'x' => (float) $nodes[$nId]->x,
                    'y' => (float) $nodes[$nId]->y,
                ];
            }
        }

        // Add destination room hotspot center if available
        if ($destination->map_x !== null && $destination->map_y !== null) {
            $destCenter = [
                'x' => round((float) $destination->map_x + ((float) ($destination->map_width ?? 0) / 2), 2),
                'y' => round((float) $destination->map_y + ((float) ($destination->map_height ?? 0) / 2), 2),
            ];
            // Only add if not identical to last point
            $lastPoint = end($pathCoordinates);
            if (!$lastPoint || $lastPoint['x'] !== $destCenter['x'] || $lastPoint['y'] !== $destCenter['y']) {
                $pathCoordinates[] = $destCenter;
            }
        }

        // 6. Calculate estimated walking minutes
        // distance (meters) / speed (1.2 m/s) / 60 = minutes
        $estimatedMinutes = (int) ceil(($totalDistance / $this->walkingSpeed) / 60);
        if ($estimatedMinutes < 1 && $totalDistance > 0) {
            $estimatedMinutes = 1;
        }

        return [
            'origin' => [
                'id' => $origin->id,
                'name' => $origin->name,
                'slug' => $origin->slug,
            ],
            'destination' => [
                'id' => $destination->id,
                'name' => $destination->name,
                'slug' => $destination->slug,
            ],
            'distance' => round($totalDistance, 1),
            'estimated_minutes' => $estimatedMinutes,
            'path' => $pathCoordinates,
        ];
    }

    /**
     * Resolve MapNode ID for a room.
     */
    protected function resolveRoomNodeId(Room $room): ?int
    {
        if ($room->map_node_id) {
            return (int) $room->map_node_id;
        }

        // If no explicit map_node_id, find closest walkable node based on map_x and map_y
        if ($room->map_x !== null && $room->map_y !== null) {
            $nodes = $this->mapRepository->getWalkableNodes();
            $closestNode = null;
            $minDistanceSq = PHP_FLOAT_MAX;

            foreach ($nodes as $node) {
                $dx = (float) $node->x - (float) $room->map_x;
                $dy = (float) $node->y - (float) $room->map_y;
                $distSq = ($dx * $dx) + ($dy * $dy);

                if ($distSq < $minDistanceSq) {
                    $minDistanceSq = $distSq;
                    $closestNode = $node;
                }
            }

            return $closestNode ? (int) $closestNode->id : null;
        }

        return null;
    }

    /**
     * Dijkstra Algorithm Implementation.
     */
    protected function dijkstra(array $graph, int $startNode, int $endNode): ?array
    {
        if ($startNode === $endNode) {
            return [
                'distance' => 0,
                'path' => [$startNode],
            ];
        }

        $distances = [];
        $previous = [];
        $unvisited = [];

        foreach (array_keys($graph) as $nodeId) {
            $distances[$nodeId] = INF;
            $previous[$nodeId] = null;
            $unvisited[$nodeId] = true;
        }

        $distances[$startNode] = 0;

        while (!empty($unvisited)) {
            // Find unvisited node with smallest distance
            $minNode = null;
            $minDist = INF;

            foreach (array_keys($unvisited) as $nodeId) {
                if ($distances[$nodeId] < $minDist) {
                    $minDist = $distances[$nodeId];
                    $minNode = $nodeId;
                }
            }

            if ($minNode === null || $minDist === INF) {
                break; // Remaining nodes unreachable
            }

            if ($minNode === $endNode) {
                break; // Reached destination
            }

            unset($unvisited[$minNode]);

            // Update distances to neighbors
            foreach ($graph[$minNode] as $neighbor => $weight) {
                if (!isset($unvisited[$neighbor])) {
                    continue;
                }

                $alt = $distances[$minNode] + $weight;
                if ($alt < $distances[$neighbor]) {
                    $distances[$neighbor] = $alt;
                    $previous[$neighbor] = $minNode;
                }
            }
        }

        if ($distances[$endNode] === INF) {
            return null; // No path exists
        }

        // Reconstruct shortest path
        $path = [];
        $curr = $endNode;
        while ($curr !== null) {
            array_unshift($path, $curr);
            $curr = $previous[$curr];
        }

        return [
            'distance' => $distances[$endNode],
            'path' => $path,
        ];
    }
}
