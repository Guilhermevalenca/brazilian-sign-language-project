<?php

namespace App\Http\Requests\know_area;

use Illuminate\Foundation\Http\FormRequest;

class StoreKnowAreaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return
            [
                'name' => ["required", "string", "max:255", "unique:know_areas"],
            ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required',
            'name.string' => 'The name field must be a string',
            'name.max' => 'The name field must be less than 255 characters',
            'name.unique:know_areas' => 'most be unique',
        ];

    }
}
