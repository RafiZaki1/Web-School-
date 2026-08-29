<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roomId = $this->route('room') ?? $this->route('id');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('rooms', 'slug')->ignore($roomId)],
            'building_name' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:room_categories,id'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable'],
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
