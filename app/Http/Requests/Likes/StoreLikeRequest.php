<?php

namespace App\Http\Requests\Likes;

use App\Http\Requests\DefaultRequest;

class StoreLikeRequest extends DefaultRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'post_id' => 'integer|exists:posts,id',
            'comment_id' => 'integer|exists:comments,id',
            'reaction_id' => 'required|integer|exists:reactions,id',
        ];
    }
}
