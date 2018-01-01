<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\HotelApp\OwnHotelRoomController;
use App\Http\Controllers\HotelApp\TravelportHotelController;
use App\Http\Controllers\HotelApp\HotelsController as DbHotelsController;
use App\Http\Controllers\HotelApp\SkyscannerHotelApiController;
use App\Http\Controllers\HotelApp\TbtqHotelController;
use App\Models\B2bApp\PackageHotelModel;
use App\Traits\CallTrait;

class HotelsController extends Controller
{
	use CallTrait;

	public function model(){
		return new PackageHotelModel;		
	}

	/*
	| this function is to get view on the browser using get request
	*/
	public function getHotelsByToken($token)
	{
		$package = PackageController::call()->model()
							->byUser()->byToken($token)->firstOrFail();
		$blade = [
				'package' => $package,
				'client' => $package->client,
			];

		return trimHtml(view('b2b.protected.dashboard.pages.hotels.index', $blade)->render());
	}



	/* 
	| this function is to insert or create new row in db
	*/
	public function createNew($object)
	{
		$packageHotel = new PackageHotelModel;
		$packageHotel->status = "active";
		$packageHotel->save();
		return $packageHotel->id;
	}


	public function postAddHotelRoom($routeId, Request $request)
	{
		$route = RouteController::call()->model()->find($routeId);
		$packageHotelId = $request->fdid; // PackageHotelModel->id
		$packageHotel = $route->fusion;
		$roomVendor = $request->rmvdr;
		$roomId = $request->rmid;

		if (is_null($packageHotel)) {
			$packageHotel = $this->model();
			$packageHotel->hotel_code = $request->fid;
			$packageHotel->vendor = $request->fvdr;
			$packageHotel->save();
			$packageHotelId = $packageHotel->id;
			
			$route->fusion_id = $packageHotelId;
			$route->fusion_type = 'App\\Models\\B2bApp\\PackageHotelModel';
			$route->status = 'complete';
			$route->save();
		}

		// save if own
		if ($roomVendor == 'own' && (is_null($roomId) || $roomId == '')) {
			$enteredRoom = DbHotelsController::call()
											->saveUserInputRooms(
													$request->fvdr,
													$request->fid,
													$request->rty
												);

			$roomId = isset($enteredRoom->id) ? $enteredRoom->id : null;
			$roomVendor = $request->fvdr;
		}


		$packageRooms = $packageHotel->roomModel();
		$packageRooms->package_hotel_id = $packageHotel->id;
		$packageRooms->roomtype_code = $roomId;
		$packageRooms->vendor = $roomVendor;
		$packageRooms->save();

		return json_encode([
				"fdid" => $packageHotelId,
				"rmdid" => $packageRooms->id,
				"rmid" => $roomId,
				"rmvdr" => $roomVendor
			]);
	}



	public function postRemoveHotelRoom($rid, Request $request)
	{
		$route = RouteController::call()->model()->find($rid);
		$count = $route->fusionCount($route->fusion_id);
		$result = [
				"fdid" => '',
				"rooms" => [],
				"status" => 200, 
				"is_copied" => 0,
				"reponse" => "delete",
			];

		if ($count > 1 && $route->fusion->packageRooms->count() > 1) {
			$packageHotel = $this->model();
			$packageHotel->hotel_code = $route->fusion->hotel_code;
			$packageHotel->vendor = $route->fusion->vendor;
			$packageHotel->save();
			$packageHotelId = $packageHotel->id;
			$result['is_copied'] = 1;
			$result['fdid'] = $packageHotelId;
			if ($route->fusion->packageRooms->count()) {
				foreach ($route->fusion->packageRooms as $packageRoom) {
					if ($packageRoom->id != $request->rmdid) {
						$packageHotelRoom = $this->model()->roomModel();
						$packageHotelRoom->package_hotel_id = $packageHotelId;
						$packageHotelRoom->roomtype_code = $packageRoom->roomtype_code;
						$packageHotelRoom->vendor = $packageRoom->vendor;
						$packageHotelRoom->save();
						$result['rooms'][$packageRoom->id] = $packageHotelRoom->id;
					}
				}
			}
			$route->fusion_id = $packageHotel->id;
			$route->fusion_type = 'App\\Models\\B2bApp\\PackageHotelModel';
			$route->status = 'complete';
			$route->save();
		}
		else {
			$this->model()->roomModel()->destroy($request->rmdid);
		}

		return json_encode($result);
	}


	// this is not using but it can be use 
	public function postSelectedHotel($rid)
	{
		$route = RouteController::call()->model()->find($rid);
		$hotel = json_encode($route->fusion->hotelForView());
		return $hotel;
	}


	/*
	| this function is to delete data by using route id
	| it only make status into "Inactive" 
	*/
	public function deleteByRoute($routeDbId)
	{
		return PackageHotelModel::where('route_id', $routeDbId)
															->update(["status" => "inactive"]);
	}


	// this function is make global array for hotel api
	public function makeApiRequestData($data)
	{
		$request = null;

		if (!is_null($data)) {

			$startDate = $data->route->start_datetime->format('d/m/Y');
			$endDate =  $data->route->end_datetime->format('d/m/Y');

			// this is global request array
			$request = [
					"Destination" => $data->route->location_hotel,
					"RoomGuests" => $data->route->package->roomGuests,
					"Nights" => $data->route->nights,
					"PreferredCurrency" => "INR",
					"Dates" => [
							"CheckInDate" => $startDate,
							"CheckOutDate" => $endDate,
						],
				];

			$request = rejson_decode($request);
		}
		return $request;
	}


	/* 
	| this function is to pull hotel rooms data using post mrthod
	*/
	public function postHotelRoom(Request $request)
	{
		$params = [
				"id" => $request->id,
				"vendor" => $request->vdr,
				"index" => $request->idx 
			];

		$rooms = DbHotelsController::call()->hotelRooms($params);
		return json_encode($rooms);
	}


	public function postHotelFacilities(Request $request)
	{
		$params = [
				"id" => $request->fid,
				"vendor" => $request->vdr
			];

		$rooms = DbHotelsController::call()->hotelFacilities($params);
		return json_encode($rooms);
	}


	public function postHotelImages(Request $request)
	{
		$params = [
				"id" => $request->fid,
				"vendor" => $request->vdr
			];

		$rooms = DbHotelsController::call()->hotelImages($params);
		return json_encode($rooms);
	}


	public function removeHotelRoom($id)
	{
		$packageHotel =  PackageHotelModel::find($id);
		$packageHotel->selected_hotel_vendor = '';
		$packageHotel->status = 'active';
		$packageHotel->save();
		return $packageHotel;
	}



	/*
	| this function is to pull data from tbtq api using TbtqHotelController
	| and it can be call using http post request
	*/
	public function postTbtqHotelResult($id)
	{
		// return file_get_contents(public_path('faker\tbtq.json'));

		$packageHotel = PackageHotelModel::call()->usersFind($id);
		$params = $this->makeApiRequestData($packageHotel);
		$result = null;

		if (!is_null($params)) {
			$result = TbtqHotelController::call()->hotel($params);
		}

		if (isset($result->db->id)) {
			$packageHotel->tbtq_temp_hotel_id = $result->db->id;
			$packageHotel->save();
		}

		return json_encode($result);
	}



	/*
	| this function is to pull data from Skyscanner api using 
	| SkyscannerHotelApiController and it can be call using http post request
	*/
	public function postSkyscannerHotelResult($id)
	{
		$packageHotel = PackageHotelModel::call()->usersFind($id);

		$result = '';

		if (!is_null($packageHotel)) {
			$result = SkyscannerHotelApiController::call()->hotels($packageHotel);
		}

		if (isset($result->db->id)) {
			$packageHotel->skysacanner_temp_hotel_id = $result->db->id;
			$packageHotel->save();
		}

		return json_encode($result);
	}


	/*
	| this function is to pull data from fgf database's agoda hotels data using 
	| AgodaHotelsController and it can be call using http post request
	*/
	public function postHotelFromDb($routeId, Request $request)
	{
		$route = RouteController::call()->model()->find($routeId);

		$selected = [];
		if (!is_null($route->fusion) && is_null($request->name)) {
			$selected = $route->fusion->hotelForView()->toArray();
		}

		$params = $route->makeHotelParams($request);
		$hotels = DbHotelsController::call()->hotels($params);
		// dd($hotels);
		$hotels = array_merge($selected, $hotels->toArray());
		$result = rejson_decode(['hotels' => $hotels]);

		if ($request->format == 'json') {
			$result = json_encode($result);
		}
		
		return $result;
	}

	/*
	| this function is to pull data from fgf database's agoda hotels data using 
	| AgodaHotelsController and it can be call using http post request
	*/
	public function postHotelFromRename($id, Request $request)
	{
		$packageHotel = PackageHotelModel::call()->usersFind($id);
		$location = $packageHotel->route->destination_detail;
		$result = (object)['hotels' => []];

		if (strlen($request->name) > 3) {
			$params = [
					'name' => $request->name,
					'latitude' => $location->latitude, 
					'longitude' => $location->longitude, 
					'max_rating' => 5,
					'min_rating' => 0,
				];
			$result->hotels = DbHotelsController::call()->hotels($params); 
		}

		return json_encode($result);
	}


	/*
	| this function is to pull data from fgf database's agoda hotels data using 
	| AgodaHotelsController and it can be call using http post request
	*/
	public function postFgfAgodaHotelResult($id, $index = 0)
	{
		$packageHotel = PackageHotelModel::call()->usersFind($id);

		$result = (object)['hotels' => []];

		if (isset($packageHotel->route->destination_agoda->city_id)) {
			$result->hotels = AgodaHotelsController::call()
							 ->hotels($packageHotel->route->destination_agoda->city_id, $index);
		}

		return json_encode($result);
	}


	public function postFgfAgodaHotelRoomResult($id, Request $request)
	{
		$agodaHotelId = $request->fid;
		$result = AgodaHotelRoomsController::call()->hotelRoom($agodaHotelId);
		return json_encode($result);
	}

	public function postFgfAgodaHotelDetail($id, Request $request)
	{
		$agodaHotelId = $request->fid;
		$result = AgodaHotelDetailsController::call()->hotelDetail($agodaHotelId);
		return $result; 
	}


	public function findHotel($id, Request $request)
	{
		$packageHotel = PackageHotelModel::find($id);
		$cityId = $packageHotel->route->destination_agoda->city_id;
		$hotel = AgodaHotelsController::call()
						->searchHotelByName($cityId, $request->name);
		
		$hotel = json_encode(["hotels" => $hotel]);

		return $hotel;
	}



}
