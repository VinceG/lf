<?php

namespace App\Http\Resources;

use App\Http\Resources\PostResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'url' => $this->url,
            'post' => new PostResource($this->whenLoaded('post'))
        ];
    }
}
