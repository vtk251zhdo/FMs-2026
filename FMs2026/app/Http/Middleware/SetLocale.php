<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{

    public function handle(Request $request, Closure $next)
    {

        $language = session('language') 
            ?? $request->cookie('language') 
            ?? 'ua';

        session(['language' => $language]);

        App::setLocale($language);

        return $next($request);
    }
}
