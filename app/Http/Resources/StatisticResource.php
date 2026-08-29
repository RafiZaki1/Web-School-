<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatisticResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_students' => (int) ($this['total_students'] ?? 0),
            'total_teachers' => (int) ($this['total_teachers'] ?? 0),
            'total_majors' => (int) ($this['total_majors'] ?? 0),
            'total_alumni' => (int) ($this['total_alumni'] ?? 0),
            'established_year' => $this['established_year'] ?? null,
        ];
    }
}
