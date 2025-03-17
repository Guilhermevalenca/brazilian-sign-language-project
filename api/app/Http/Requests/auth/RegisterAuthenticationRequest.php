<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAuthenticationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required','email'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ];
    }
}
