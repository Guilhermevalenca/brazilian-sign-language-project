<?php

namespace App\Http\Requests\description;

use Illuminate\Foundation\Http\FormRequest;

class StoreDescriptionRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'text' => ['required', 'string'],
            'display' => ['required', 'string'],
            'sign_id' => ['required', 'exists:signs,id'],
        ];
    }
}
