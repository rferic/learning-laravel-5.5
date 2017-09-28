<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Forum;

use App\Http\Requests\ForumRequest;

use App\Category;

class ForumController extends Controller
{
    public function index ()
    {
        // TODO Order DESC
        //$forums = Forum::latest()->with('replies', 'posts')->paginate(2);
        // TODO Get links paginate
        // $links = $forums->links();
        // TODO Getter from Scope (Queries Eloquent) => Example: search() == call ==> scopeSearch()
        $forums = Forum::search();

        return view('forums.index', compact('forums'));
    }

    // TODO `function`(`TYPE` `$var`)
    // TODO Get Model from GET PARAMS
    public function show (Forum $forum)
    {
        $posts = $forum->posts()->with(['owner', 'categories'])->paginate(2);

        // TODO pluck => Return Array from Model
        $categories = Category::pluck('name', 'id');

        return view( 'forums.detail', compact('forum', 'posts', 'categories', 'currentCategories'));
    }

    public function store (ForumRequest $request)
    {
        Forum::create(request()->all());
        // TODO Return back after save
        return back()->with('message', ['class' => 'success', 'text' => __('Forum has been created')]);
    }

    public function search ()
    {
        // TODO Check if request is POST
        if (request()->isMethod('POST')) {
            $search = request('search');

            if ($search) {
                // TODO PUT & Save Session
                request()->session()->put('search', $search);
                request()->session()->save();
            } else {
                // TODO Remove Session param
                request()->session()->forget('search');
            }
        }

        return redirect('/');
    }

    public function clearSearch ()
    {
        request()->session()->forget('search');
        return back();
    }
}
