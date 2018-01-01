<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\BookingHotelFacilityModel;
use App\Http\Controllers\HotelApp\BookingScrapeController;
use App\Traits\CallTrait;

class BookingHotelFacilitiesController extends Controller
{
	use CallTrait;

	public $bookingHotelId;


	public function model()
	{
		return new BookingHotelFacilityModel;
	}


	public function facilities($hotelId)
	{
		$this->bookingHotelId = (int) $hotelId;
		$facilities = $this->model()->facilities($this->bookingHotelId);
		
		if (!count($facilities)) {
			$facilities = BookingScrapeController::call($this->bookingHotelId)
											->extractFacilities();
			$this->model()->insert($this->makeInsertArray($facilities));
		}
		return $facilities;
	}


	public function makeInsertArray(Array $facilities)
	{
		$data = [];
		foreach ($facilities as $facility) {
			$data[] = addDateColumns([
									"booking_hotel_id" => $this->bookingHotelId,
									"facility" => $facility,
								]);
		}
		return $data;
	}
}
