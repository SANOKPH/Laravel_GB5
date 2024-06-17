<?php

namespace App\Http\Resources\Friends;

use App\Http\Resources\User\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestToFriendResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new ProfileResource($this->receiver)
        ];
    }
}
