<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGameSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (!session()->has('user_id')) {
            return redirect('/login')->with('error', 'Будь ласка, увійдіть до системи.');
        }

        $userClub = \App\Models\UserClub::where('UserID', session('user_id'))->first();
        if (!$userClub) {
            return redirect('/start-game')->with('error', 'Будь ласка, оберіть клуб для управління.');
        }

        return $next($request);
    }
}
