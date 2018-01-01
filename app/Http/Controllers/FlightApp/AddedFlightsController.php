<?php

namespace App\Http\Controllers\FlightApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FlightApp\AddedFlightSegmentModel;
use App\Models\FlightApp\AddedFlightModel;
use App\Models\B2bApp\RouteModel;
use App\Traits\CallTrait;
use Carbon\Carbon;

class AddedFlightsController extends Controller
{
	use CallTrait;


	public function model()
	{
		return new AddedFlightModel;
	}


	public function saveFlight(Request $reqeust)
	{
		$addedFlight = $this->model();
		$addedFlight->origin = $route->origin_code;
		$addedFlight->destination = $route->destination_code;
		$addedFlight->date = $route->start_date;
		$addedFlight->save();

		$segments = $this->fixSegments($addedFlight->id, $reqeust->segments);
		$segmentRes = AddedFlightSegmentModel::insert($segments);
		$addedFlight->refresh();

		return $addedFlight->segments->pluck('built_data');
	}



	public function fixSegments($addedFlightId, $segments)
	{
		$res = [];
		foreach ($segments as $segment) {
			$segment = collect($segment);
			$departureDateTime = $this->fixDates($segment->pull('departure'));
			$arrivalDateTime = $this->fixDates($segment->pull('arrival'));
			
			$res[] = [
					"added_flight_id" => $addedFlightId,
					"name" => $segment->pull('name'),
					"code" => $segment->pull('code'),
					"number" => $segment->pull('number'),
					"origin_code" => $segment->pull('origin_code'),
					"destination_code" => $segment->pull('destination_code'),
					"departure_date_time" => $departureDateTime,
					"arrival_date_time" => $arrivalDateTime,
				];
		}

		return $res;
	}



	public function fixDates($date)
	{
		return Carbon::createFromFormat('Y/m/d H:i', $date)
										->toDateTimeString();
	}


	/*
	| this function for if flight is booked
	| id stand for the table id 
	| index for the result column array index like flight index 
	*/
	public function book($id)
	{
		$flight = $this->model()->find($id);
		$return = false;
		if (!is_null($flight)) {
			$return =  $flight->firstLastDateTime();
		}
		return $return;
	}


}
