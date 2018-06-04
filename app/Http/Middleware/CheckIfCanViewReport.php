<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfCanViewReport
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
        if(!Auth()->user()->isAdmin() && !Auth()->user()->isGuard() &&!Auth()->user()->isDetectiv() && !Auth()->user()->isMainOrganizer()){
            return redirect()->route('home');
        }
        return $next($request);
    }
}
