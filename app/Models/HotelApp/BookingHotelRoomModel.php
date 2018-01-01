<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;

class BookingHotelRoomModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql4';
	protected $table = 'booking_hotel_rooms';
	protected $appends = ['name', 'built_data', 'vendor'];
	protected $hidden = ['created_at', 'updated_at'];


	public function getVendorAttribute()
	{
		return 'b';
	}


	public function getBuiltDataAttribute()
	{
		return collect([
				'id' => $this->id,
				'roomtype' => $this->roomtype,
				'property_type' => $this->roomtype,
				'vendor' => $this->vendor
			]);
	}

	public function getNameAttribute()
	{
		return $this->roomtype;
	}


	public function findByHotelId($bookingHotelId)
	{
		return $this->select(['id', 'roomtype'])
									->where(["booking_hotel_id" => $bookingHotelId])
										->groupBy('roomtype')
											->get();
	}


	public function bookingHotel()
	{
		return $this->belongsTo(
											'App\Models\HotelApp\BookingHotelModel',
											'booking_hotel_id', 'id'
										);
	}

}
