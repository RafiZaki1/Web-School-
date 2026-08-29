<?php

namespace App\Http\Requests\Map;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class RouteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from' => ['required', 'string'],
            'to' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'from.required' => 'Lokasi asal (from) wajib diisi.',
            'to.required' => 'Lokasi tujuan (to) wajib diisi.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $from = $this->input('from');
            $to = $this->input('to');

            if ($from && $to && strtolower(trim((string) $from)) === strtolower(trim((string) $to))) {
                $validator->errors()->add('to', 'Lokasi asal dan tujuan tidak boleh sama.');
            }
        });
    }
}
