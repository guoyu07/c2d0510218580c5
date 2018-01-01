<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;

class TboHotelRoomModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'tbo_hotel_rooms';
	protected $appends = ['built_data', 'vendor'];

	public function getVendorAttribute()
	{
		return 'tbo';
	}

	public function getBuiltDataAttribute()
	{
		return collect([
				'id' => $this->id,
				'vendor' => $this->vendor,
				'property_type' => $this->roomtype,
				'roomtype' => $this->roomtype
			]);
	}

	public function scopeByHotelCode($query, $code)
	{
		return $query->where('hotel_code', $code);
	}


}
