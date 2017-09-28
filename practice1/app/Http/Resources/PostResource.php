<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

use App\Http\Resources\ReplyResource;

use Carbon\Carbon;

class PostResource extends Resource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'attachment' => !is_null($this->attachment) ? $request->root() . $this->pathAttachment() : NULL,
            'replies' => ReplyResource::collection($this->whenLoaded('replies')),
            'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d-m-Y H:i'),
            'owner' => $this->owner
        ];
    }
}
