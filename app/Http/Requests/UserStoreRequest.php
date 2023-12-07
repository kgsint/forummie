<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->can('create', User::class);
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,email',
            'password' => 'required|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => 'The :attribute cannot be empty',
        ];
    }
}
