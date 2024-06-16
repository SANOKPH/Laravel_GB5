<?php

namespace App\Http\Resources\Friends;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListFriendRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'profile' => $this->sender || $this->receiver
        ];
    }
}
