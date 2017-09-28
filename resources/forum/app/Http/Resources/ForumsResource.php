<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;

class ForumsResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
	        "name" => $this->name,
	        "slug" => $this->slug,
	        "description" => $this->description,
	        "posts" => PostsResource::collection($this->whenLoaded('posts')),
	        "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d-m-Y')
        ];
    }
}
