<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class SkyscannerCarModel extends Model
{
	protected $table = 'skyscanner_cars';
	protected $appends = ['car', 'days'];
	protected $casts = [
			'request' => 'object',
			'result' => 'object'
		];


	// public function setRequestAttribute($value)
	// {
	// 	if (is_array($value) || is_object($value)) {
	// 		$value = json_encode($value);
	// 	}
	// 	$this->attributes['request'] = $value;
	// }

	// public function setResultAttribute($value)
	// {
	// 	if (is_array($value) || is_object($value)) {
	// 		$value = json_encode($value);
	// 	}
	// 	$this->attributes['result'] = $value;
	// }

	public function getCarAttribute()
	{
		$result = $this->result;
		$car = null;
		if (isset($result->cars[$this->selected_index])) {
			$car = $result->cars[$this->selected_index];
		}
		return $car;
	}

	public function getDaysAttribute()
	{
		$carRequest = $this->request;
		$days = date_differences(
			date_formatter($carRequest->end_date, "d/m/Y"),
			date_formatter($carRequest->start_date, "d/m/Y")
		) + 1;
		return $days;
	}



}
