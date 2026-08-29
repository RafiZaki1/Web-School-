<?php

namespace App\Http\Requests\Map;

use Illuminate\Foundation\Http\FormRequest;

class StoreMapNodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'x' => ['required', 'numeric', 'between:0,100'],
            'y' => ['required', 'numeric', 'between:0,100'],
            'is_walkable' => ['nullable', 'boolean'],
        ];
    }
}
