<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminApp\EnquiryController;
use View;

class DashboardController extends Controller
{
	public $viewPath = 'admin.protected.dashboard.pages';

	public function getIndex(Request $request){
		$clients = EnquiryController::call()->model()
							->byAdmin(1)->byNotStatus()
								->searchName($request->search)
									->simplePaginate(20);
		$blade = [
				"clients" => $clients
			];
		return view($this->viewPath.'.index.index', $blade);
	}

	public function getSlug($page = 'index')
	{
		if (View::exists($this->viewPath.'.'.$page)) {
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


			return view($this->viewPath.'.'.$page, []);
		}
		else{
			return view('errors.404');
		}
	}
}
