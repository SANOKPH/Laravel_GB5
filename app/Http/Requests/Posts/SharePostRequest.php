<?php

namespace App\Http\Requests\Posts;

use App\Http\Requests\DefaultRequest;

class SharePostRequest extends DefaultRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'post_id' => 'required|exists:posts,id'
        ];
    }
}
