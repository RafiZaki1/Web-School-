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
        $data = is_array($this->resource) ? $this->resource : (array) $this->resource;

        return [
            'total_students' => (int) ($data['total_students'] ?? 0),
            'total_teachers' => (int) ($data['total_teachers'] ?? 0),
            'established_year' => isset($data['established_year']) && $data['established_year'] !== null ? (int) $data['established_year'] : null,
            'total_majors' => (int) ($data['total_majors'] ?? 0),
            'total_alumni' => (int) ($data['total_alumni'] ?? 0),
        ];
    }
}
