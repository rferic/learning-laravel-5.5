<?php

namespace App\Http\Controllers;

class AppController extends Controller
{
	public function setLanguage($lang) {
		if (array_key_exists($lang, config('languages'))) {
			session()->put('applocale', $lang);
		}
		return back();
	}
}
