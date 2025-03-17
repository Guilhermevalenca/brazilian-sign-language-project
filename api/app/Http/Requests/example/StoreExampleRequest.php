<?php

namespace App\Http\Requests\example;

use Illuminate\Foundation\Http\FormRequest;

class StoreExampleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => ['required', 'string'],
            'display' => ['required', 'string'],
            'sign_id' => ['required', 'exists:signs,id'],
        ];
    }
}
