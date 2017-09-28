<?php

namespace App\Http\Controllers;

use App\Category;
use App\Forum;

class ForumsController extends Controller
{
    public function index() {
		$forums = Forum::with(['replies', 'posts'])->paginate(2);
		return view('forums.index', compact('forums'));
    }

    public function show(Forum $forum) {
    	$posts = $forum->posts()->with(['owner', 'categories'])->paginate(2);

    	$categories = Category::pluck('name', 'id');

    	return view('forums.detail', compact('forum', 'posts', 'categories'));
    }

    public function store() {
    	$this->validate(request(), [
    		'name' => 'required|max:100|unique:forums',
    		'description' => 'required|max:500',
	    ]);
	    Forum::create(request()->all());
	    return back()->with('message', ['success', __("Foro creado correctamente")]);
    }
}
