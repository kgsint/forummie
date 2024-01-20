<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->can('update', $this->route('post')) ?? false;
    }

    public function rules(): array
    {
        return [
            'body' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'body.required' => 'The :attribute cannot be empty',
        ];
    }
}
