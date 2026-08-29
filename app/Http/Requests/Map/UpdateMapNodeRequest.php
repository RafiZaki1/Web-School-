<?php

namespace App\Http\Requests\Map;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMapNodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'x' => ['sometimes', 'required', 'numeric', 'between:0,100'],
            'y' => ['sometimes', 'required', 'numeric', 'between:0,100'],
            'is_walkable' => ['nullable', 'boolean'],
        ];
    }
}
