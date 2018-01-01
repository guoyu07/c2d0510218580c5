<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FlightApp\QpxFlightsController;
use App\Http\Controllers\FlightApp\AddedFlightsController;
use App\Http\Controllers\FlightApp\TravelportAirController;
use App\Http\Controllers\FlightApp\SkyscannerFlightsController;
use App\Http\Controllers\FlightApp\AddedFlightSegmentsController;
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Models\B2bApp\PackageServiceModel;
use App\Models\B2bApp\PackageFlightModel;
use App\Traits\CallTrait;
use Carbon\Carbon;

class FlightsController extends Controller
{
	use CallTrait;
	public $viewPath = 'b2b.protected.dashboard.pages.flights';


	public function model()
	{
		return new PackageFlightModel;
	}


	public function findRoute($routeId)
	{
		return RouteController::call()->model()->find($routeId);
	}

	/*
	| this function is to get view on the browser using get request
	*/
	public function getFlightsByToken($token, Request $request)
	{
		$package = PackageController::call()->model()
									->byUser()->byToken($token)->firstOrFail();

		$flightRoutes = $package->flightRoutes;

		if (is_array($request->only) && !empty($request->only)) {
			$flightRoutes = $flightRoutes->filter(function($item) use ($request){
				if (in_array($item->token, $request->only)) {
					return $item;
				}
			})->values();
		}

		if (!$flightRoutes->count()) {
			$flightRoutes = $package->flightRoutes;
		}

		$blade = [
				'package'  => $package,
				'client' 	 => $package->client,
				'flightRoutes' => $flightRoutes,
				'viewPath' => $this->viewPath
			];

		return trimHtml(view($this->viewPath.'.index', $blade)->render());
	}



	public function postBookFlightsResult($rToken, Request $request){
		$route = RouteController::call()->model()
						->byToken($rToken)->first();

		$returnArray = error500();
		
		if (!is_null($route)) {

			$vendor = $request->vdr;
			$vendorId = $request->vid;
			$index = $request->ind;

			$packageFlight = $this->model();
			$packageFlight->flight_id = $vendorId;
			$packageFlight->flight_type = $this->getFlightModelName($vendor);
			$packageFlight->index = $index;
			$packageFlight->save();

			$service = new PackageServiceModel;
			$service->type = 'flight';
			$service->fusion_id = $packageFlight->id;
			$service->fusion_type = PackageFlightModel::class;
			$service->save();

			$route->packageServices()->attach([$service->id]);
			$packageFlight->refresh();
			$route->start_date = $packageFlight->start_date_time->date;
			$route->start_time = $packageFlight->start_date_time->time;
			$route->end_date = $packageFlight->end_date_time->date;
			$route->end_time = $packageFlight->end_date_time->time;
			$route->status = 'complete';
			$route->save();
			$route->refresh();
			$route->fixNextDates();

			$returnArray = [ 
				"status" => 200,
				"id" => $service->id,
				"response" => 'data saved successfully',
				"start_date_time" => $packageFlight->start_date_time,
				"end_date_time" => $packageFlight->end_date_time,
			];
		}
		
		return json_encode($returnArray);
	}



	public function deleteBookFlightResult($rToken, Request $request)
	{
		$route = RouteController::call()->model()
							->byToken($rToken)->first();
		if (!is_null($route) && isset($request->psid)) {
			$route->packageServices()->detach([$request->psid]);
		}
		return ['status' => 200, 'response' => 'removed successfully.'];
	}



	public function removeCustomFlights($rid, Request $request)
	{
		$res = AddedFlightSegmentsController::call()
					->model()->removeSegment($request->vsid);

		$status = $res ? 200 : 500;
		return json_encode(['status' => $status]);
	}


	public function postFlightResult($vendor, $rToken, Request $request)
	{
		// return file_get_contents(storage_path('mylocal/faker/global_flights_with_connections.json'));

		$result = [];
		$route = RouteController::call()->model()
						->byToken($rToken)->first();

		if (!is_null($route)) {
			if ($vendor == 'qpx') {
				$result = QpxFlightsController::call()
									->postFlight($route->makeQpxRequest());
			}
			elseif ($vendor == 'ss') {

			}// use elseif for another vendor
		}

		return json_encode($result);
	}


	
	public function removeFlight($routeId)
	{
		$route = $this->findRoute($routeId);
		$route->fusion_id = '';
		$route->fusion_type = '';
		$route->status = 'active';
		$route->save();
	}


	public function saveCustomFlights(Request $request)
	{
		$connections = collect($request->flights)->map(function($item){
			$segment = collect($item);
			$number = strlen($segment->get('number')) > 3
							? substr($segment->get('number'), 2)
							: $segment->get('number');

			$code = strlen($segment->get('code'))
						? $segment->get('code')
						: substr($segment->get('number'), 0, 2);

			$departureDateTime = Carbon::createFromFormat('d/m/Y H:i', $segment->pull('departure'))->toDateTimeString();

			$arrivalDateTime = Carbon::createFromFormat('d/m/Y H:i', $segment->pull('arrival'))->toDateTimeString();

			return collect([
							"name" => $segment->pull('name'),
							"code" => $code,
							"number" => $number,
							"origin_code" => $segment->pull('origin_code'),
							"destination_code" => $segment->pull('destination_code'),
							"departure_date_time" => $departureDateTime,
							"arrival_date_time" => $arrivalDateTime,
						]);
		});

		$res = AddedFlightSegmentsController::call()->saveFlights($connections);
		return $res->built_data->toJson();
	}



	public function postQpxFlightResult($id)
	{
		// return file_get_contents(storage_path('mylocal/faker/qpx.json'));
		$route = RouteController::call()->model()->find($id);
		$result = [];

		if (!is_null($route)) {
			$result = QpxFlightsController::call()->flights($route);
		}

		return json_encode($result);
	}


	public function postSkyscannerFlightResult($id)
	{
		// $result = file_get_contents(storage_path('faker/ssflight.json'));
		$route = RouteController::call()->model()->find($id);
		$result = '';
		if (!is_null($packageFlight)) {
			$result = SkyscannerFlightsController::call()->flights($route);
		}
		return json_encode($result);
	}

	public function postTravelportFlight($rid)
	{
		$route = RouteController::call()->model()->find($rid);
		$result = null;

		if (!is_null($route)) {

			$params = [
				"date" => $route->start_date,
				"origin" => $route->originCode,
				"destination" => $route->destinationCode,
			];

			$result = TravelportAirController::call()->flights($params);
		}

		return json_encode($result);
	}



	public function getFlightModelName($key)
	{
		return collect([
				'qpx' => 'App\Models\FlightApp\QpxFlightModel',
				'ss'	=> 'App\Models\FlightApp\SkyscannerFlightsModel',
				'own' => 'App\Models\FlightApp\AddedFlightSegmentModel',
			])->get($key);
	}




}
