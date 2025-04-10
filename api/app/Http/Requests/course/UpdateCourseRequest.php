<?php

namespace App\Http\Requests\course;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'name' => ['string'],
            'subjects' => ['nullable'],
            'subjects.*' => ['integer', 'exists:subjects,id'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg'],
            'keywords' => ['required'],
            'keywords.*' => ['integer', 'exists:keywords,id'],
        ];
    }
}
