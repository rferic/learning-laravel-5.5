<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;
use App\Http\Helpers\ImageHelper;

class PostController extends Controller
{
    public function show (Post $post)
    {
        $replies = $post->replies()->with('author')->paginate(2);
        return view('posts.detail', compact('post', 'forum', 'replies'));
    }

    public function store (PostRequest $request)
    {
        // TODO Check if has file & if is valid
        if ($request->hasFile('file') && $request->file('file')->isValid())
        {
            $filename = ImageHelper::uploadFile('file', 'posts');
            $request->merge(['attachment' => $filename]);
        }

        Post::create($request->input());
        return back()->with('message', ['class' => 'success','text' => __('Post has been created')]);
    }

    public function destroy (Post $post)
    {
        if (!$post->isOwner()) {
            // TODO Abort for ERROR
            abort(401);
        }

        $post->delete();
        return back()->with('message', ['class' => 'success', 'text' => __('Post has been removed')]);
    }
}
