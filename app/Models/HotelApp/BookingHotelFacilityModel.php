<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;

class BookingHotelFacilityModel extends Model
{

	protected $connection = 'mysql4';
	protected $table = 'booking_hotel_facilities';


	public function findByHotelId($hotelId)
	{
		return $this->where(['booking_hotel_id' => $hotelId])->get();
	}

	public function facilities($hotelId)
	{
		$data = $this->findByHotelId($hotelId);
		$facilities = [];
		
		foreach ($data as $facility) {
			$facilities[] = $facility->facility;
		}

		return array_values(array_unique($facilities));
	}

}
