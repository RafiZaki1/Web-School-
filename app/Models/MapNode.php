<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\MapEdge;

class MapNode extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'x',
        'y',
        'is_walkable',
    ];

    protected $casts = [
        'x' => 'float',
        'y' => 'float',
        'is_walkable' => 'boolean',
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'map_node_id');
    }

    public function outgoingEdges(): HasMany
    {
        return $this->hasMany(MapEdge::class, 'from_node_id');
    }

    public function incomingEdges(): HasMany
    {
        return $this->hasMany(MapEdge::class, 'to_node_id');
    }

    public function scopeWalkable(Builder $query): Builder
    {
        return $query->where('is_walkable', true);
    }
}
