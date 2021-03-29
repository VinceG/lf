<?php

namespace App\Http\Resources;

use App\Http\Resources\FileResource;
use App\Http\Resources\TagResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'owner' => new UserResource($this->whenLoaded('owner')),
            'main_image' => new FileResource($this->whenLoaded('file')),
            'tags' => TagResource::collection($this->whenLoaded('tags'))
        ];
    }
}
