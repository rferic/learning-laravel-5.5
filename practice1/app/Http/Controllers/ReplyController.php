<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ReplyRequest;

use App\Reply;
use App\Http\Helpers\ImageHelper;

class ReplyController extends Controller
{
    public function __construct ()
    {
        // TODO Middleware in to Controller
        $this->middleware('auth')->only(['store', 'destroy']);
    }

    public function store (ReplyRequest $request)
    {
        // TODO Check if has file & if is valid
        if ($request->hasFile('file') && $request->file('file')->isValid())
        {
            $filename = ImageHelper::uploadFile('file', 'replies');
            $request->merge(['attachment' => $filename]);
        }

        Reply::create($request->input());
        return back()->with('message', ['class' => 'success', 'text' => __('Reply has been published')]);
    }

    public function destroy (Reply $reply)
    {
        $reply->delete();
        return back()->with('message', ['class' => 'success', 'text' => __('Reply has been removed')]);
    }
}
