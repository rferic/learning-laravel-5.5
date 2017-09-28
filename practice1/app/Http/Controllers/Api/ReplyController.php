<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\ReplyResource;

use App\Reply;

class ReplyController extends Controller
{
    public function index (Reply $reply)
    {
        return ReplyResource::collection($reply->paginate(2));
    }

    public function show (Reply $reply)
    {
        // TODO API: Return a Item
        return new ReplyResource($reply);
    }
}
