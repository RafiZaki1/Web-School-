<?php

namespace App\Http\Requests\SchoolProfile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'school_name' => ['sometimes', 'required', 'string', 'max:255'],
            'school_logo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'principal_name' => ['nullable', 'string', 'max:255'],
            'principal_position' => ['nullable', 'string', 'max:255'],
            'principal_photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'welcome_message' => ['nullable', 'string'],
            'background_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'established_year' => ['nullable', 'integer', 'min:1800', 'max:2100'],
        ];
    }
}
