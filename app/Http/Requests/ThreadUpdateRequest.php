<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThreadUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('update', $this->route('thread'));
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'body' => 'required',
            'topic_id' => 'required|exists:topics,id',
        ];
    }

    public function messages(): array
    {
        return [
            'topic_id.required' => 'Please choose a topic',
            '*.required' => 'The :attribute cannot be empty',
        ];
    }
}
