<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotTraveler
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = 'traveler')
	{
	    if (!Auth::guard($guard)->check()) {
	    	session()->put('url.intended', \URL::current());
	      return redirect('login-register');
	    }

	    return $next($request);
	}
}