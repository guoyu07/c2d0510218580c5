<?php

namespace App\Http\Middleware;

use Closure;

class BackendSuperUserArea
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
		$auth = auth()->guard('backend')->user();
		
		if ($auth->type != 'su') {
			session()->flash('danger', 'Permission denied! You have no access to go there.');
			return redirect('dashboard');
		}

		return $next($request);
	}
}
