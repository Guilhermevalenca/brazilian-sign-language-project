<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'display' => ['required', 'string', 'max:255'],

            'description' => ['nullable', 'array'],
            'description.text' => ['required_with:description', 'string'],
            'description.display' => ['required_with:description', 'string'],

            'example' => ['nullable', 'array'],
            'example.description' => ['required_with:example', 'string'],
            'example.display' => ['required_with:example', 'string'],

            'keywords' => ['required', 'array'],
            'keywords.*' => ['required_with:keywords', 'integer', 'exists:keywords,id'],

            'subjects' => ['required', 'array'],
            'subjects.*' => ['required_with:subjects', 'integer', 'exists:subjects,id'],
        ];
    }
}
