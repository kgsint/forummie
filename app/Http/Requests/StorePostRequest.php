<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'body' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'The :attribute cannot be empty',
        ];
    }
}
