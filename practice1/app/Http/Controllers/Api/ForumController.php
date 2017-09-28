<?php

namespace App\Http\Controllers\Api;

use App\Forum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\ForumResource;

class ForumController extends Controller
{
    public function index (Forum $forum)
    {
        // TODO Call ELoquent API Resource
        // TODO with('{model}') => Add items Model
        // TODO API: Return a Collection
        return ForumResource::collection($forum->with('posts')->paginate(2));
    }

    public function show (Forum $forum)
    {
        // TODO API: Return a Item
        return new ForumResource($forum->with('posts')->first());
    }
}
