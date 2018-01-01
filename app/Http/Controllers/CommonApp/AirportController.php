<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonApp\AirportModel;
use App\Traits\CallTrait;


class AirportController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new AirportModel;
	}


	public function getAirport(Request $request){

		$airportsData = $this->model()
										->getAirportAndLocation($request->term);
		$airports = [];
		
		foreach ($airportsData as $airport) {
			$airports[] = $airport->airports;
		}

		return json_encode($airports);
	}


	public function names(Request $request)
	{
		$result = $this->model()->getAirportNames($request->term);
										
		return json_encode($result);
	}
}
