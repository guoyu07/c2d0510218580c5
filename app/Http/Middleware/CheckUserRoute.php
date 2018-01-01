<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\B2bApp\RouteController;

class CheckUserRoute
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
		$check = RouteController::call()->model()
						->byToken($request->rtoken)
							->byPackageUser()->count();
		return $check ? $next($request) : jsonError('invalid user');
	}
}
