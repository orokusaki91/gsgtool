<?php

namespace App\Http\Middleware;

use Closure;
use App\Theft;

class MenageTheft
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
        $theft = Theft::findOrFail($request->theft_id);
        if(!Auth()->user()->isAdmin() && $theft->user_id != Auth()->user()->id){
            return redirect()->route('home');
        }
        return $next($request);
    }
}
