<?php

namespace App\Http\Requests\subject;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
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
            'courses' => ['array'],
            'courses.*' => ['integer', 'exists:courses,id'],
            'keywords' => ['required', 'array'],
            'keywords.*' => ['required', 'integer', 'exists:keywords,id'],
        ];
    }

}
