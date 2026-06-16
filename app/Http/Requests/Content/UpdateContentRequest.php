<?php

namespace App\Http\Requests\Content;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContentRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'category_id' => ['required', 'exists:categories,id'],
            'regency_id'  => ['required', 'exists:regencies,id'],
            'address'     => ['nullable', 'string', 'max:500'],
            'maps_url'    => ['nullable', 'url', 'max:500'],
            'photos'      => ['nullable', 'array', 'max:5'],
            'photos.*'    => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
