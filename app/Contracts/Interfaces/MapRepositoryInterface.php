<?php

namespace App\Contracts\Interfaces;

use App\Models\MapEdge;
use App\Models\MapNode;
use Illuminate\Database\Eloquent\Collection;

interface MapRepositoryInterface
{
    public function getAllNodes(): Collection;

    public function getWalkableNodes(): Collection;

    public function findNodeOrFail(int|string $id): MapNode;

    public function createNode(array $data): MapNode;

    public function updateNode(MapNode $node, array $data): MapNode;

    public function deleteNode(MapNode $node): bool;

    public function getAllEdges(): Collection;

    public function getWalkableEdges(): Collection;

    public function findEdgeOrFail(int|string $id): MapEdge;

    public function createEdge(array $data): MapEdge;

    public function updateEdge(MapEdge $edge, array $data): MapEdge;

    public function deleteEdge(MapEdge $edge): bool;
}
