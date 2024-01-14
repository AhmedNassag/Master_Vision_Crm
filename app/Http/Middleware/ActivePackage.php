<?php

namespace App\Http\Middleware;

use Closure;
use Dwij\Laraadmin\Models\LAConfigs;
class ActivePackage
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
        $end_date = \Carbon\Carbon::parse(LAConfigs::getByKey('end_date'));
        if($end_date<\Carbon\Carbon::now())
        {
            \Auth::logout();
            return redirect('/login');
        }
        return $next($request);
    }
        
}
