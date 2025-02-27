<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginAuthenticationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required','email'],
            'password' => ['required', 'string', 'min:6']
        ];
    }
}
