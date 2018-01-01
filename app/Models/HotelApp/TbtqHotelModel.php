<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;

class TbtqHotelModel extends Model
{
	protected $table = 'tbtq_hotels';
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
		if (isset($result->HotelSearchResult->HotelResults[$this->selected_index])) {
			$hotel = $result->HotelSearchResult->HotelResults[$this->selected_index];
		}
		return $hotel;
	}


	/*
	| this function is for getting package data 
	| from package table behalf of package_id
	*/
	public function tbtqRooms()
	{
		return $this->belongsTo('App\Models\HotelApp\TbtqHotelRoomModel', 'tbtq_hotel_room_id');		
	}

	public function tbtqDetail()
	{
		return $this->belongsTo('App\Models\HotelApp\TbtqHotelDetailModel', 'tbtq_hotel_detail_id');		
	}


}
