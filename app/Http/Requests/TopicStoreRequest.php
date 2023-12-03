<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdmin() || auth()->user()->isModerator();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:topics,name',
            'slug' => 'required|unique:topics,slug',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'The :attribute cannot be empty',
        ];
    }
}
