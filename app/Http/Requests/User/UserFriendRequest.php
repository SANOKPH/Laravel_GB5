<?php

namespace App\Http\Requests\User;

use App\Http\Requests\DefaultRequest;

class UserFriendRequest extends DefaultRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'friend_id' => 'required|exists:users,id',
        ];
    }
}
