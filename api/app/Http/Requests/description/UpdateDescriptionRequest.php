<?php

namespace App\Http\Requests\description;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDescriptionRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'text' => ['required', 'string'],
            'display' => ['required', 'string'],
        ];
    }
}
