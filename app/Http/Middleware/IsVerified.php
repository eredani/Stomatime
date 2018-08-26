<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class IsVerified
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
        if (Auth::user()->verified == 1)
        {
            return $next($request);  
        }
        else
        {
            Auth::logout();
            return redirect()->route('login')->with('email','Email-ul nu este verificat.');
        }
        return $next($request);
    }
}
