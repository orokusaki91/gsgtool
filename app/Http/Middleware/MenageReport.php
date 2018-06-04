<?php

namespace App\Http\Middleware;

use Closure;
use App\Report;

class MenageReport
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
        $report = Report::findOrFail($request->report_id);
        if(!Auth()->user()->isAdmin() && $report->user_id != Auth()->user()->id){
            return redirect()->route('home');
        }
        return $next($request);
    }
}
