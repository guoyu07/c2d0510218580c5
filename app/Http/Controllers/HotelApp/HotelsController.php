<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HotelApp\TbtqHotelsController;
use App\Http\Controllers\HotelApp\AgodaHotelsController;
use App\Http\Controllers\HotelApp\BookingHotelsController;
use App\Http\Controllers\HotelApp\AgodaHotelsRoomsController;
use App\Http\Controllers\HotelApp\BookingHotelRoomsController;
use App\Models\HotelApp\HotelModel;
use App\Traits\CallTrait;


class HotelsController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new HotelModel;
	}


	public function hotelByCode(Array $params)
	{
		$params = (object) $params;
		$hotel = collect([]);
		
		if ($params->vendor == 'a') {
 			$hotel = AgodaHotelsController::call()
 							->model()->hotelByCode($params->code);
		}
		elseif ($params->vendor == 'b') {
 			$hotel = BookingHotelsController::call()
 							->model()->hotelByCode($params->code);
		}

		return $hotel;
	}


	public function hotels(Array $params = [])
	{
		$params = (object) $params;
		$name = $params->name;
		$lat = $params->latitude;
		$long = $params->longitude;
		$skip = isset($params->skip) ? $params->skip : 0;
		$take = isset($params->take) ? $params->take : 10;

		$hotels = collect([]);
		
		$searchFunctions = [
				'bySearch',
				'bySearchSemiBroad',
				'bySearchBroad',
				'bySearchCases',
			];

		foreach ($searchFunctions as $searchFunction) {
			$hotels = $this->model()->select()->with('vendor')
								->$searchFunction($name)->byLatLong($lat, $long);

			if ($searchFunction != 'bySearchCases') $hotels->byVendor();

			$hotels = $hotels->skip($skip)->take($take)->get();

			if ($hotels->count()) break;
		}

 		return $hotels->pluck('vendor.built_data')->toArray();
	}


	public function hotelsOld($params = [])
	{

 		$hotels = BookingHotelsController::call()->model()
 							->hotelsByLatLong($params);

 		if (!$hotels->count()) {
 			$hotels = AgodaHotelsController::call()->model()
 								->hotelsByLatLong($params);
 		}

 		return $hotels;
	}


	public function hotelRooms(Array $params = [])
	{
		$params = collect($params);
		$id = $params->get('id');
		$vendor = $params->get('vendor');
		$result = [];

		if ($vendor == 'b') {
			$result = BookingHotelRoomsController::call()->rooms($id);
		}
		elseif ($vendor == 'a') {
			$result = AgodaHotelRoomsController::call()->rooms($id);
		}
		elseif ($vendor == 'tbo') {
			$result = TbtqHotelController::call()
								->hotelRoomsAndImages($id, $params->toArray());
		}

		return $result;
	}

	public function hotelFacilities($params=[])
	{
		$params = (object) $params;
		$result = [];

		if ($params->vendor == 'b') {
			$result = BookingHotelFacilitiesController::call()
								->facilities($params->id);
		}
		elseif ($params->vendor == 'a') {
			$result = AgodaHotelRoomsController::call()->facilities($params->id);
		}

		return $result;
	}

	public function hotelImages(Array $params = [])
	{
		$params = (object) $params;
		$result = [];

		if ($params->vendor == 'b') {
			$result = BookingHotelImagesController::call()
								->images($params->id);
		}
		elseif ($params->vendor == 'a') {
			$result = AgodaHotelImagesController::call()
								->images($params->id);
		}

		return $result;
	}

	public function saveUserInputRooms($vendor, $vendorId, $roomType)
	{
		$result = null;

		if ($vendor == 'b') {
			$result = BookingHotelRoomsController::call()->model();
			$result->booking_hotel_id = $vendorId;
			$result->roomtype = $roomType;
			$result->save();
		}
		elseif ($vendor == 'a') {
			$result = AgodaHotelRoomsController::call()->model();
			$result->hotel_id = $vendorId;
			$result->roomtype = $roomType;
			$result->save();
		}

		return $result;
	}


}
