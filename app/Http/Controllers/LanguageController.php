<?php

namespace App\Http\Controllers;

class LanguageController extends Controller
{
    /**
     * 言語切り替え
     *
     * @param string $lang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang($lang)
    {
        if (array_key_exists($lang, \Config::get('languages'))) {
            \Session::put('applocale', $lang);
        }

        return back();
    }
}
