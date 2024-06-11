<?php

namespace App\Http\Resources\Posts;

use App\Http\Resources\Media\ListMediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "image" => ListMediaResource::collection($this->medias),
        ];
    }
}
