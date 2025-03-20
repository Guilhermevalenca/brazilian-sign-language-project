<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithFiltersKeywordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search' => ['required', 'string'],
            'filterOptions' => ['required', 'array'],
            'filterOptions.courses' => ['required', 'boolean'],
            'filterOptions.subjects' => ['required', 'boolean'],
            'filterOptions.signs' => ['required', 'boolean'],
        ];
    }
}
