<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\B2bApp\CabsController;
use App\Http\Controllers\B2bApp\HotelsController;
use App\Http\Controllers\B2bApp\FlightsController;
use App\Http\Controllers\B2bApp\FollowUpController;
use App\Http\Controllers\B2bApp\ActivitiesController;
use App\Traits\CallTrait;

class MenusController extends Controller
{
	use CallTrait;

	public function getPackageMenus($packageDbId){
		$followUps = $this->getFollowUps();
		$cabs = CabsController::call()->getAllCabs($packageDbId);
		$flights = FlightsController::call()->getAllFlights($packageDbId);
		$hotels = HotelsController::call()->hotelList($packageDbId, false);
		// $activities = ActivitiesController::call()->getAllActivities($packageDbId);
		$activities = [];
		$result = (object)[
			"hotels" => $hotels,
			"flights" => $flights,
			"activities" => $activities,
			"cabs" => $cabs,
			"followUps" => $followUps
		];
		return $result;
	}

	public function getFollowUps(){
		return FollowUpController::call()->all();
	}
}
