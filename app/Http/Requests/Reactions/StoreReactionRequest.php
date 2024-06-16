<?php

namespace App\Http\Requests\Reactions;

use App\Http\Requests\DefaultRequest;

class StoreReactionRequest extends DefaultRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'string|required|unique:reactions',
            'user_id'=>'required|integer|exists:users,id'
        ];
    }
}
