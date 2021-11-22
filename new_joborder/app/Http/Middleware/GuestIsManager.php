<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
class GuestIsManager
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
        if(Auth::user()->level != 4){
            return redirect('/');
        }
        return $next($request);
    }
}
