<?php

namespace App\Http\Requests\Comments;

use App\Http\Requests\DefaultRequest;

class StoreCommentRequest extends DefaultRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'text' => 'string|required',
            'comment_id' => 'integer|exists:comments,id',
            'post_id' => 'integer|exists:posts,id',
            'image' => 'image|max:5120',
        ];
    }
}
