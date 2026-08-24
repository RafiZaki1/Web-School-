<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'name',
        'icon',
        'quantity',
        'description',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'room_id' => 'integer',
    ];

    /**
     * Get the room that owns the facility.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
