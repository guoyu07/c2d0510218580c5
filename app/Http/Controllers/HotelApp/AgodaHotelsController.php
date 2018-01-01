<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HotelApp\AgodaHotelRoomsController;
use App\Http\Controllers\HotelApp\AgodaHotelImagesController;
use App\Http\Controllers\HotelApp\AgodaHotelDetailsController;
use App\Models\HotelApp\AgodaHotelModel;
use App\Traits\CallTrait;

class AgodaHotelsController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new AgodaHotelModel;
	}


	public function hotels($cityId, $index)
	{
		$hotels = [];
		
		if ($cityId != '') {
			$hotels = AgodaHotelModel::call()->hotelsByCityId($cityId, $index);
		}
		
		return $hotels;
	}


	public function searchHotelByName($cityId, $name)
	{
		$hotels = [];
		
		if ($cityId != '') {
			$hotels = AgodaHotelModel::call()->searchHotelByName($cityId, $name);
		}
		
		return $hotels;
	}


	public function searchHotelsByName($cityId, $name)
	{
		$hotels = [];
		
		if ($cityId != '') {
			$hotelsData = AgodaHotelModel::call()->searchHotelsByName($cityId, $name);
			foreach ($hotelsData as $hotelData) {
				$hotels[] = $hotelData->hotel_name;
			}
		}
		
		return $hotels;
	}


	public function storeHotelDetail()
	{
		$agodaHotel = AgodaHotelModel::select()
									->where(['is_stored_room' => 0])
										->first();

		if (!is_null($agodaHotel)) {
			$rooms = AgodaHotelRoomsController::call()->rooms($agodaHotel->hotel_id);
		}

		return $agodaHotel;
	}


	public function loopHotelDetails()
	{
		ini_set('max_execution_time', 3600);

		if (!env('IS_LOCALHOST')) {
			for ($i=1; $i > 0; $i++) { 
				$result = $this->storeHotelDetail();
				if (is_null($result)) {
					break;
				}
			}
		}
	}
	
}
