<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;

class AgodaHotelRoomModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql4';
	protected $appends = ['vendor', 'name'];
	protected $table = 'agoda_hotel_rooms';


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


	public function getVendorAttribute()
	{
		return 'a';
	}

	public function findByHotelId($hotelId)
	{
		return $this->select(['id', 'roomtype', 'image'])
										->where(["hotel_id" => $hotelId])
											->groupby('roomtype')
												->get();
	}


	
	public function agodaHotel()
	{
		return $this->belongsTo(
											'App\Models\HotelApp\AgodaHotelModel', 
											'hotel_id', 'hotel_id'
										);
	}
}
