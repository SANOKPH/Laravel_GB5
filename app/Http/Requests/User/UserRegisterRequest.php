<?php

namespace App\Http\Requests\User;

use App\Http\Requests\DefaultRequest;

class UserRegisterRequest extends DefaultRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:10',
            'password' => 'required|string|min:6',
            'date_of_birth' => 'required|date',
            'role'  => 'required|string'
        ];
    }
}
