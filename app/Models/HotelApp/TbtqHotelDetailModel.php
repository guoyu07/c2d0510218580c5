<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;

class TbtqHotelDetailModel extends Model
{
	use CallTrait;

	protected $table = 'tbtq_hotel_details';
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


	/*
	| this function for finding hotel detail form db behalf of hotel code
	| if data not exist then it will return 'null'
	*/
	public function findByHotelCode($hotelCode)
	{
		$result = null;
		$data = $this->select()
									 ->where(["hotel_code" => $hotelCode, "status" => "active"])
									 ->first();

		if (!is_null($data)) {
			
			$result = $data->result;
			$result->db = (object)["id" => $data->id, "table" => "tbtq_hotel_details"];

			if (ifset($result->HotelInfoResult->ResponseStatus) != 1) {
				$data->status = 'inactive';
				$data->save();
			}
		}
		return $result;
	}


}
