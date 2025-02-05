<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSignRequest extends FormRequest
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
        return [
            'name' => ['required', 'string'],
            'display' => ['required', 'string'],
            'moveset' => ['nullable', 'array'],
            'moveset.right' => ['required_with:moveset', 'string'],
            'moveset.left' => ['required_with:moveset', 'string'],
            'examples' => ['nullable', 'array'],
            'examples.*.description' => ['required_with:examples', 'string'],
            'examples.*.display' => ['required_with:examples', 'string'],
            'description' => ['nullable', 'array'],
            'description.text' => ['required_with:description', 'string'],
            'description.display' => ['required_with:description', 'string'],
        ];
    }
}
