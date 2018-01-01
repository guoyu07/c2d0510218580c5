<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;

class AgodaHotelImageModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'agoda_hotel_images';
	protected $hidden = ['created_at', 'updated_at'];

	public function findByHotelId($hotelId)
	{
		return $this->select()
									->where(['hotel_id' => $hotelId])
										->get();
	}


}
