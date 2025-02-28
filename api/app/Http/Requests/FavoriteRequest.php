<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FavoriteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sign_id' => ['required', 'exists:signs,id'],
        ];
    }
}
