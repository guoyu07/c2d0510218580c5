<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\PackageServiceModel;
use App\Models\B2bApp\PackageAccommodationModel;
use App\Models\B2bApp\PackageAccommodationPropertyModel;
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\HotelsController;
use App\Http\Controllers\B2bApp\CruisesController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\B2bApp\PackageServiceController;
use App\Http\Controllers\HotelApp\TbtqHotelController;
use App\Http\Controllers\HotelApp\HotelsController as DbHotelsController;
use App\Http\Controllers\HotelApp\TbtqHotelsController;
use App\Http\Controllers\HotelApp\AgodaHotelRoomsController;
use App\Http\Controllers\HotelApp\BookingHotelRoomsController;
use App\Http\Controllers\CruiseApp\CruisesController as DbCruisesController;
use App\Traits\CallTrait;

class AccommodationController extends Controller
{
	use CallTrait;

	public $viewPath = 'b2b.protected.dashboard.pages.accomo';


	public function model()
	{
		return new PackageAccommodationModel;
	}


	/*
	| this function is to get view on the browser using get request
	*/
	public function getHotelsByToken($token, Request $request)
	{
		$package = PackageController::call()->model()
							->byUser()->byToken($token)->firstOrFail();

		$accomoRoutes = $package->accomoRoutes;

		if (is_array($request->only) && !empty($request->only)) {
			$accomoRoutes = $accomoRoutes->filter(function($item) use ($request){
				if (in_array($item->token, $request->only)) {
					return $item;
				}
			})->values();
		}

		if (!$accomoRoutes->count()) {
			$accomoRoutes = $package->accomoRoutes;
		}

		/*$eventActionUrl = $package->packageEvent
											->where('event', 'accommodation')
												->eventActionUrl();*/

		$indication = indication();

		// $spots = $indication->byCategory('transfer_spot')->get();
		// $modes = $indication->byCategory('transfer_mode')->get();

		// $spotModes = [];
		// foreach ($spots as $spot) {
		// 	foreach ($modes as $mode) {
		// 		$spotModes[$spot->name][$spot->key.'|'.$mode->key] 
		// 										= $spot->name.' ('.$mode->name.')';
		// 	}
		// }

		// dd($spot, $mode, $spotModes);

		$blade = [
				'package'	=> $package,
				'viewPath'	=> $this->viewPath,
				'client'	=> $package->client,
				'indication'	=> $indication,
				'accomoRoutes'	=> $accomoRoutes,
				// 'spots' 	 => $spots,
				// 'modes' 	 => $modes,

			];
		return myView($this->viewPath.'.index', $blade);
	}


	/*
	| getting hotels list if want hotel with 
	| name then pass name parameter
	| if want as json then pass format = json 
	| default is object
	*/
	public function postAccomo($rToken, Request $request)
	{
		$request->merge(['name' => $request->term]);

		$route = RouteController::call()->model()
						->byToken($rToken)->firstOrFail();


		$result = '[]';

		if (in_array($route->mode, ['hotel', 'hotel_only'])) {
			if ($request->vendor == 'tbo') {
				$tboRequest = $route->makeTboHotelRequest([
							'PreferredHotel' => $request->term
						]);
				if (!is_null($tboRequest)){
					$hotels = TbtqHotelController::call()->hotels($tboRequest);
					$result = $hotels->built_data;
				} 
			}
			else{
				$result = DbHotelsController::call()
									->hotels($route->makeHotelParams($request));
			}
		}
		elseif ($route->mode == 'cruise') {

			$result = DbCruisesController::call()
								->cruises($route->makeCruiseParams($request));

		}

		$result =  ['accommodations' => $result];

		if ($request->format == 'json') {
			$result = json_encode($result);
		}

		return $result;
	}


	public function postRemoveAccomo($rToken)
	{
		return RouteController::call()->postRemoveFusion($rToken);
	}


	public function postAccomoProp($rToken, Request $request)
	{
		$route = RouteController::call()->model()
						->byToken($rToken)->first();

		$result = [];
		$vendor = $request->vdr;
		$id = $request->id;
		if (in_array($route->mode, ['hotel', 'hotel_only'])) {
			if ($vendor == 'b') {
				$result = BookingHotelRoomsController::call()->rooms($id);
			}
			elseif ($vendor == 'a') {
				$result = AgodaHotelRoomsController::call()->rooms($id);
			}
			elseif ($vendor == 'tbo') {
				$params = [
						"id" => $request->id,
						"vendor" => $request->vdr,
						"index" => $request->idx 
					];

				$result = TbtqHotelController::call()
									->hotelRoomsAndImages($request->id, $params);
			}
		}
		elseif ($route->mode == 'cruise') {
			$params = [
						"id" => $request->id,
						"vendor" => $request->vdr,
						"index" => $request->idx 
					];
			$result = DbCruisesController::call()
								->cruiseCabinsAndImages($params);

		}
		return $result;
	}


	public function postAccomoFacilities($rToken, Request $request)
	{
		$route = RouteController::call()->model()
						->byToken($rToken)->first();

		$result = [];
		if (in_array($route->mode, ['hotel', 'hotel_only'])) {
			$result = HotelsController::call()->postHotelFacilities($request);
		}
		elseif ($route->mode == 'cruise') {
			$result = CruisesController::call()->postCruiseFacilities($request);
		}
		return $result;
	}


	public function postAccomoImages($rToken, Request $request)
	{
		$route = RouteController::call()->model()
						->byToken($rToken)->first();
		$result = [];
		if (in_array($route->mode, ['hotel', 'hotel_only'])) {
			$result = HotelsController::call()->postHotelImages($request);
		}
		elseif ($route->mode == 'cruise') {
			$result = CruisesController::call()->postCruiseImages($request);
		}
		return $result;
	}


	public function postAddProp($rToken, Request $request)
	{
		$route = RouteController::call()->model()
						->byToken($rToken)->firstOrFail();


		if (!$route->checkMode('accommodation')){
		 return json_encode([
		 		'status' => 500,
		 		'response' => 'invalid request',
		 	]);
		}

		
		$service = null;
		$serviceIds = [];
		$packageAccomo = null; // package_accommodation model
		$params = $request->accommodation;

		$packageServicesId = array_get($params, 'psid');
		$pkgAccomoId = array_get($params, 'id');
		$pkgAccomoIndex = array_get($params, 'index');
		$pkgAccomoVendor = array_get($params, 'vendor');

		// getting all route id which is belongs to same service
		$belongWithTo = $route->packageServices
										->where('type', 'accommodation')
											->pluck('pivot.route_id')
												->flatten()->unique();


		// check if service belongs to other route if not then use last one 
		if ($belongWithTo->count() == 1 && $belongWithTo->first() == $route->id) {
			$service = $route->packageServices
								->where('id', $packageServicesId)
									->first();

			if (isset($service->fusion)) {
				$packageAccomo = $service->fusion;
			}
		}

		if (is_null($packageAccomo)) {
			$packageAccomo = $this->model();
			$packageAccomo->accommodation_id = $pkgAccomoId;
			$packageAccomo->accommodation_type = 
					$packageAccomo->getVendorModelName($pkgAccomoVendor);
			$packageAccomo->index = $pkgAccomoIndex;
			$packageAccomo->save();
		}

		if (is_null($service)) {
			$service = new PackageServiceModel;
			$service->type = 'accommodation';
			$service->fusion_id = $packageAccomo->id;
			$service->fusion_type = PackageAccommodationModel::class;
			$service->save();
		}

		$serviceIds[] = $service->id;

		$packageProps = null;
		$packageAccomoPropId = array_get($params, 'property.papid');
		$packagePropId = array_get($params, 'property.id');
		$packagePropVendor = array_get($params, 'property.vendor');
		$noOfRooms = array_get($params, 'property.no_of_rooms');

		if ($packageAccomo->packageAccommodationProperties->count() && strlen($packageAccomoPropId)) {
			$packageProps = $packageAccomo->packageAccommodationProperties
											->where('id', $packageAccomoPropId)
												->first();
		}

		if (is_null($packageProps)) {
			$packageProps = new PackageAccommodationPropertyModel;
		}

		$packageProps->package_accommodation_id = $packageAccomo->id;
		$packageProps->type = $route->checkMode('hotel') ? 'room' : 'cabin';
		$packageProps->no_of_rooms = $noOfRooms;
		$packageProps->property_id = $packagePropId;
		$packageProps->property_type = $packageProps->getVendorModelName(
																			$packagePropVendor
																		);
		$packageProps->save();
		
		$route->refresh();

		if (!$route->packageServices->where('pivot.package_service_id', $service->id)->count()) {
			$route->packageServices()->attach($serviceIds);
		}

		$route->status = 'complete';
		$route->save();

		return json_encode([
				"status" => 200,
				"response" => "saved successfully.",
				"psid" => (int) $service->id,
				"papid" => (int) $packageProps->id,
			]);
	}



	public function postRemoveProp($rToken, Request $request)
	{
		$route = RouteController::call()->model()
						->byToken($rToken)->firstOrFail();
		
		$serviceIds = [];

		$result = [
				"status" => 200, 
				"reponse" => "delete"
			];


		if (!$route->checkMode('accommodation')){
		 return json_encode([
		 		'status' => 500,
		 		'response' => 'invalid request',
		 	]);
		}

		
		$packageProperty = $route->packageServices
												->pluck('fusion.packageAccommodationProperties')
													->flatten()->unique('id')
														->where('id', $request->papid)->first();

		if (is_null($packageProperty)) return json_encode($result); 



		// getting all route id which is belongs to same service
		$belongWithTo = $route->packageServices
										->where('type', 'accommodation')
											->pluck('pivot.route_id')
												->flatten()->unique();
		
		$serviceOld = $packageProperty->packageAccommodation->packageService;
		
		// check if service belongs to other route or not
		$result = [
				"psid" => $serviceOld->id,
				"ids" => [],
				"status" => 200, 
				"is_copied" => 0,
				"reponse" => "delete",
			];

		if ($belongWithTo->count() == 1 && $belongWithTo->first() == $route->id) {
			$packageProperty->delete();
			$serviceOld->refresh();

			if ($packageProperty->packageAccommodation->packageAccommodationProperties->count() < 1) {
				$serviceIds[] = $serviceOld->id; 
				$serviceOld->delete();
			}

		}
		else{
			if (isset($serviceOld->fusion) && !is_null($serviceOld->fusion)) {
				$allProperties = $serviceOld->fusion
												->pluck('packageAccommodationProperties')
													->where('id', '<>', $packageProperty->id);

				if ($allProperties->count() > 1 ) {
					$packageAccomo = $this->model();
					$packageAccomo->accommodation_id = $serviceOld->fusion
																								->accommodation_id;
					$packageAccomo->accommodation_type = $serviceOld->fusion
																								->accommodation_type;
					$packageAccomo->index = $serviceOld->fusion->index;
					$packageAccomo->save();

					$service = new PackageServiceModel;
					$service->type = $serviceOld->type;
					$service->fusion_id = $packageAccomo->id;
					$service->fusion_type = PackageAccommodationModel::class;
					$service->save();

					foreach ($allProperties as $packagePropertyOld) {
						$newPkgProp = new PackageAccommodationPropertyModel;
						$newPkgProp->package_accommodation_id = $packageAccomo->id;
						$newPkgProp->type = $packagePropertyOld->type;
						$newPkgProp->no_of_rooms = $packagePropertyOld->no_of_rooms;
						$newPkgProp->property_id = $packagePropertyOld->property_id;
						$newPkgProp->property_type = $packagePropertyOld->property_type;
						$newPkgProp->index = $packagePropertyOld->index;
						$newPkgProp->save();

						// old id is key and new id is val
						$result['ids'][$packagePropertyOld->id] = $newPkgProp->id;
					}

					$result['psid'] = $service->id;
					$result['is_copied'] = 1;
				}
			}
		}

		$route->packageServices()->detach($serviceIds);
		$route->refresh();
		if (!$route->packageServices->count()) {
			$route->status = 'active';
			$route->save();
		}

		return json_encode($result);


	}


	public function searchProp($rToken, Request $request)
	{
		$result  = json_decode($this->postAccomo($rToken, $request));
		return isset($result->accommodations) 
				 ? json_encode($result->accommodations)
				 : '[]';

		/*$result = [];
		$route = RouteController::call()->model()
						->byToken($rToken)->first();
		if (in_array($route->mode, ['hotel', 'hotel_only'])) {
			$location = $route->destination_detail;
			$params = [
						'name' => $request->term,
						'latitude' => $location->latitude, 
						'longitude' => $location->longitude, 
						'maxRating' => 5,
						'minRating' => 0,
					];

			if ($request->want == 'name') {
				$params['nameOnly'] = 1;
			}

			$result = DbHotelsController::call()
								->model()->fatchHotels($params);
		}
		elseif ($route->mode == 'cruise') {
			$result = CruisesController::call()
								->searchCruiseNames($rToken, $request);
		}

		if (strtolower($request->format) == 'json') {
			$result = json_encode($result);
		}

		return $result;*/
	}


	public function getPackageAccommodationPropertyModelName($key)
	{
		$models = collect([
						'a' => 'App\Models\HotelApp\AgodaHotelRoomModel',
						'b' => 'App\Models\HotelApp\BookingHotelRoomModel',
						'tbo' => 'App\Models\HotelApp\TboHotelRoomModel',
					]);

		return $models->get($key);
	}


	


	public function postAddAttributes($rToken, Request $request)
	{
		$route = RouteController::call()->model()
							->byToken($rToken)->first();

		if (isset($request->pick_up) && isset($request->is_pick_up)) {
			$route->is_pick_up = $request->is_pick_up;
			$route->pick_up = $request->pick_up;
		}

		if (isset($request->pick_up_mode)) {
			$route->pick_up_mode = $request->pick_up_mode;
		}


		if (isset($request->drop_off) && isset($request->is_drop_off)) {
			$route->is_drop_off = $request->is_drop_off;
			$route->drop_off = $request->drop_off;
		}


		if (isset($request->drop_off_mode)) {
			$route->drop_off_mode = $request->drop_off_mode;
		}
		

		if (isset($request->breakfast)) {
			$route->is_breakfast = $request->breakfast;
		}


		if (isset($request->lunch)) {
			$route->is_lunch = $request->lunch;
		}

		if (isset($request->dinner)) {
			$route->is_dinner = $request->dinner;
		}

		$route->save();
	}

	public function addPropertyManually(Request $request)
	{
		$result = DbHotelsController::call()->saveUserInputRooms(
						$request->accomo_vendor,
						$request->accomo_id,
						$request->proptype
					);

		$status = isset($result->id) ? 200 : 500;
		$response = isset($result->id) 
							? 'saved successfully' 
							: 'unable to save';

		return json_encode([
									'status' => $status, 
									'id' => $result->id, 
									'response' => $response
							]);
	}




}
