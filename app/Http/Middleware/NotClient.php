<?php

namespace App\Http\Middleware;

use Closure;

class NotClient
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
        if(Auth()->user()->isClient()){
            return redirect()->route('home');
        }
        return $next($request);
    }
}
