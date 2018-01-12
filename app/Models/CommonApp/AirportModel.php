<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommonApp\DestinationModel;
use App\Traits\Models\CommonApp\AirportModelTrait;
use App\Traits\CallTrait;

class AirportModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql2';
	protected $table = 'airports';
	protected $appends = [
									'location', 'destination_details', 
									'latitude', 'longitude'
								];


	public function getLocationAttribute()
	{
		$country = isset($this->attributes['country']) 
						 ? $this->attributes['country']
						 : '';

		$destination = isset($this->attributes['city']) 
						 ? $this->attributes['city']
						 : '';

		return echoLocation($destination, $country);
	}
	


	public function getDestinationDetailsAttribute()
	{
		return DestinationModel::byCountryCode($this->country_code)
															->byDestination($this->city)
																->first();
	}


	public function getLatitudeAttribute()
	{
		return isset($this->destination_details->latitude) 
				 ? $this->destination_details->latitude
				 : '';
	}
	

	public function getLongitudeAttribute()
	{
		return isset($this->destination_details->longitude) 
				 ? $this->destination_details->longitude
				 : '';;
	}



}
