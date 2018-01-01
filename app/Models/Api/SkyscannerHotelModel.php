<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;

class SkyscannerHotelModel extends Model
{
	use CallTrait;

	protected $table = 'skyscanner_hotels';
	protected $appends = ['hotel'];
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

	public function getHotelAttribute()
	{
		$result = $this->result;
		$hotel = null;
		if (isset($result->hotels[$this->selected_index])) {
			$hotel = $result->hotels[$this->selected_index];
		}
		return $hotel;
	}


	public function hotelDetailTemp()
	{
		return $this->belongsTo('App\Models\Api\SkyscannerHotelDetailModel', 'skysacanner_temp_hotel_detail_id');
	}

	public function hotelDetail()
	{
		return $this->belongsTo('App\Models\Api\SkyscannerHotelDetailModel', 'skysacanner_hotel_detail_id');
	}


}
