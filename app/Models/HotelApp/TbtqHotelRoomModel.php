<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;

class TbtqHotelRoomModel extends Model
{
	protected $table = 'tbtq_hotel_rooms';

	protected $casts = [
			'request' => 'object',
			'result' => 'object'
		];

	public function setRequestAttribute($value)
	{
		if (is_array($value) || is_object($value)) {
			$value = json_encode($value);
		}
		$this->attributes['request'] = $value;
	}

	public function setResultAttribute($value)
	{
		if (is_array($value) || is_object($value)) {
			$value = json_encode($value);
		}
		$this->attributes['result'] = $value;
	}
	
}
