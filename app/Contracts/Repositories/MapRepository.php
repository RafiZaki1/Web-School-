<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\MapRepositoryInterface;
use App\Models\MapEdge;
use App\Models\MapNode;
use Illuminate\Database\Eloquent\Collection;

class MapRepository implements MapRepositoryInterface
{
    public function getAllNodes(): Collection
    {
        return MapNode::query()->orderBy('id')->get();
    }

    public function getWalkableNodes(): Collection
    {
        return MapNode::query()->walkable()->orderBy('id')->get();
    }

    public function findNodeOrFail(int|string $id): MapNode
    {
        return MapNode::query()->whereKey($id)->firstOrFail();
    }

    public function createNode(array $data): MapNode
    {
        return MapNode::create($data);
    }

    public function updateNode(MapNode $node, array $data): MapNode
    {
        $node->update($data);
        return $node->fresh();
    }

    public function deleteNode(MapNode $node): bool
    {
        return (bool) $node->delete();
    }

    public function getAllEdges(): Collection
    {
        return MapEdge::query()->with(['fromNode', 'toNode'])->orderBy('id')->get();
    }

    public function getWalkableEdges(): Collection
    {
        return MapEdge::query()
            ->walkable()
            ->with(['fromNode', 'toNode'])
            ->orderBy('id')
            ->get();
    }

    public function findEdgeOrFail(int|string $id): MapEdge
    {
        return MapEdge::query()->with(['fromNode', 'toNode'])->whereKey($id)->firstOrFail();
    }

    public function createEdge(array $data): MapEdge
    {
        return MapEdge::create($data);
    }

    public function updateEdge(MapEdge $edge, array $data): MapEdge
    {
        $edge->update($data);
        return $edge->fresh(['fromNode', 'toNode']);
    }

    public function deleteEdge(MapEdge $edge): bool
    {
        return (bool) $edge->delete();
    }
}
