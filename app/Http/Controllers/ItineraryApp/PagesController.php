<?php

namespace App\Http\Controllers\ItineraryApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonApp\UrlController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Traits\CallTrait;

class PagesController extends Controller
{
	use CallTrait;

	public function pages($token, $page=null,  Request $request)
	{
		$packageCont = new PackageController;

		$package = $packageCont->model();
		
		if (!$request->is_preview) {
			$package = $package->byIsLocked();
		}

		$package = $package->byToken($token)->firstOrFail();

		$comparePackage = null;
		if ($page == 'compare') {
			$comparePackage = $packageCont->model()->byIsLocked()
										->byToken($request->compare_token)
											->firstOrFail();
		}

		if ($package->cost->total_cost < 1) exitView();

		$url = $request->fullUrl();
		
		if (is_null($page)) {
			$page = 'home';
			$url = str_replace($token, $token.'/'.$page, $url);
		}

		$tempUrl = str_replace($token.'/'.$page, $token.'/{}', $url);

		$urlObj = new UrlController(['url' => $tempUrl]);

		$blade = [
				"url" => $url,
				"token" => $token,
				"urlObj" => $urlObj,
				"package" => $package,
				"comparePackage" => $comparePackage,
				"is_preview" => $request->is_preview
			];

		return view('subway.pages.'.$page, $blade);
	}



}
