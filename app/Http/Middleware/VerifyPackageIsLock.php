<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\B2bApp\PackageController;

class VerifyPackageIsLock
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
		if (isset($request->ctoken) && is_null($request->token)) {
			return $next($request);
		}
	
		$packageObj = new PackageController; 
		$package = $packageObj->model()->byUser()
								->byToken($request->token)->firstOrFail();

		// this for route modification 
		if ($package->is_locked) {
			$newPackage = $packageObj->makePackageRaplica($package->id);
			$token = $newPackage->token;
			$url = str_replace(
								['{ctoken}', '{token}',  '{token?}'], 
								[$request->ctoken, $token, $token], 
								$request->route()->uri
							);

			return redirect($url);
		}

		if (!$package->modifiable() && !isset($request->ctoken)) {
			return redirect(route('package.notmodifiable'));
		}


		return $next($request);
	}
}
