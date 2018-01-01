<?php

namespace App\Models\CruiseApp;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CruiseItineraryModel extends Model
{
	protected $connection = 'mysql5';
	protected $table = 'cruise_itineraries';

	public function getEtaAttribute($value)
	{
		return Carbon::parse($value);
	}


	public function getEtdAttribute($value)
	{
		return Carbon::parse($value);
	}


}
