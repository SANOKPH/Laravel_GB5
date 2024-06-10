<?php

namespace App\Http\Requests\User;

use App\Http\Requests\DefaultRequest;

class UserLoginRequest extends DefaultRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'     => 'required|string|max:255',
            'password'  => 'required|string'
        ];
    }
}
