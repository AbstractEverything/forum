<?php

namespace App\Http\Middleware;

use Closure;

class IsBanned
{
    /**
     * Return a 403 if the user is banned.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! auth()->check())
        {
            return $next($request);
        }

        if (auth()->user()->banned == true)
        {
            return abort(403, 'Sorry you have been banned!');
        }

        return $next($request);
    }
}
