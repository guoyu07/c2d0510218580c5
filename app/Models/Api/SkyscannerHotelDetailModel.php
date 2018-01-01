<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class SkyscannerHotelDetailModel extends Model
{
	protected $table = 'skyscanner_hotel_details';
	protected $appends = ['images'];
	protected $casts = [
			'result' => 'object'
		];



	public function setResultAttribute($value)
	{
		if (is_array($value) || is_object($value)) {
			$value = json_encode($value);
		}
		$this->attributes['result'] = $value;
	}

	public function getImagesAttribute($value='')
	{
		$result = json_decode($this->attributes['result']);
		$imageHost = $result->image_host_url;
		$images = [];

		if (isset($result->hotels[0]->images)) {
			$images = $result->hotels[0]->images;
		}

		$images = ssImageArrayFix($images, $imageHost);
		return $images;
	}

}
