<?php

namespace App\Http\Middleware;

use App;
use Closure;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Session::has('applocale') && array_key_exists(\Session::get('applocale'), \Config::get('languages'))) {
            \App::setLocale(\Session::get('applocale'));
        } else {
            \App::setLocale(\Config::get('app.fallback_locale'));
        }

        return $next($request);
    }
}
