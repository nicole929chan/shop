<?php

namespace App\Http\Middleware;

use Closure;

class AbortIfUnauthroized
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
        if (auth('web')->user()->admin) {
            return $next($request);    
        }

        abort(403);
    }
}
