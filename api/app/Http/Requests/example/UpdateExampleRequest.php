<?php

namespace App\Http\Requests\example;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExampleRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'description' => ['required', 'string'],
            'display' => ['required', 'string'],
        ];
    }
}
