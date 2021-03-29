<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected bool $showToken = false;

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource, bool $showToken = false)
    {
        parent::__construct($resource);
        
        $this->showToken = $showToken;
    }

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
            'name' => $this->name,
            'email' => $this->email,
            $this->mergeWhen($this->showToken, function() {
                return [
                    'token' => auth()->tokenById($this->id)
                ];
            })
        ];
    }
}
