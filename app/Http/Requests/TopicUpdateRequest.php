<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TopicUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return request()->user()->isAdmin() || request()->user()->isModerator();
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('topics', 'name')->ignore($this->route('topic')->id)
            ],
            'slug' => [
                'required',
                'string',
                Rule::unique('topics', 'slug')->ignore($this->route('topic')->id)
            ],
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'The :attribute cannot be empty',
        ];
    }
}
