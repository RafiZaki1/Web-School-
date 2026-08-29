<?php

namespace App\Http\Requests\Map;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMapEdgeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_node_id' => ['sometimes', 'required', 'integer', 'exists:map_nodes,id'],
            'to_node_id' => ['sometimes', 'required', 'integer', 'exists:map_nodes,id', 'different:from_node_id'],
            'distance' => ['sometimes', 'required', 'numeric', 'min:0'],
            'is_walkable' => ['nullable', 'boolean'],
        ];
    }
}
