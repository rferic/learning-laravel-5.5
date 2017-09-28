<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\PostResource;
use App\Post;

class PostController extends Controller
{
    public function index (Post $post)
    {
        return PostResource::collection($post->with('replies')->paginate(2));
    }

    public function show (Post $post)
    {
        // TODO API: Return a Item
        return new PostResource($post->with('replies')->first());
    }
}
