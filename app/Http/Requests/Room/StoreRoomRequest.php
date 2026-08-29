<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:rooms,slug'],
            'building_name' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:room_categories,id'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
            'open_hours' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'map_x' => ['nullable', 'numeric', 'between:0,100'],
            'map_y' => ['nullable', 'numeric', 'between:0,100'],
            'map_width' => ['nullable', 'numeric', 'between:0,100'],
            'map_height' => ['nullable', 'numeric', 'between:0,100'],
            'map_node_id' => ['nullable', 'integer', 'exists:map_nodes,id'],
        ];
    }
}
