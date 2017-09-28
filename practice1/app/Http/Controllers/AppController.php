<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    // TODO Set Language
    public function setLanguage ($lang)
    {
        if (array_key_exists($lang, config('languages')))
        {
            session()->put('applocale', $lang);
        }

        return back();
    }
}
