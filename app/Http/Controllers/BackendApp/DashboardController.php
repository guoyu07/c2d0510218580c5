<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;

class DashboardController extends Controller
{
  public function getIndex($page = 'index'){
		if (View::exists('backend.protected.dashboard.pages.'.$page)) {
			// $client = ClientController::call()->all();
			

			// /*
			// | this is for time or clock which is showing time,
			// | in that checking into that array which is second paramenter 
			// | that page is in array if yes then show clock
			// */
			// $onload = '';
			// if (in_array($page, ['index'])) {
			// 	$onload = 'onload=startTime()';
			// }

			// // ===============================Blade Object===============================

			// $blade = (object)[
			// 		"other" => (object)["onload" => $onload],
			// 	];


			return view('backend.protected.dashboard.pages.'.$page, []);
		}
		else{
			return view('errors.404');
		}
	}
}
