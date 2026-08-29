<?php

namespace App\Contracts\Interfaces;

use App\Models\MapEdge;
use App\Models\MapNode;
use Illuminate\Database\Eloquent\Collection;

interface MapServiceInterface
{
    public function getAllNodes(): Collection;

    public function getWalkableNodes(): Collection;

    public function getNodeById(int|string $id): MapNode;

    public function createNode(array $data): MapNode;

    public function updateNode(int|string $id, array $data): MapNode;

    public function deleteNode(int|string $id): bool;

    public function getAllEdges(): Collection;

    public function getWalkableEdges(): Collection;

    public function getEdgeById(int|string $id): MapEdge;

    public function createEdge(array $data): MapEdge;

    public function updateEdge(int|string $id, array $data): MapEdge;

    public function deleteEdge(int|string $id): bool;
}
