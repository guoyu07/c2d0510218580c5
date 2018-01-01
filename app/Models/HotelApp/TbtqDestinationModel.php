<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;

class TbtqDestinationModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'tbtq_destinations';
	protected $appends = ['location'];
	protected $hidden = ['created_at', 'updated_at'];


	public function getLocationAttribute()
	{
		return $this->destination.', '.$this->country;
	}


	public function scopeByCountry($query, $country)
	{
		return $query->where('country', $country);
	}


	public function scopeByCountryCode($query, $country)
	{
		return $query->where('country_code', $country);
	}


	public function scopeByDestination($query, $destination)
	{
		return $query->where('destination', $destination);
	}

	public function scopeByDestinationCode($query, $code)
	{
		return $query->where('destination_code', $code);
	}

	public function scopeBySearch($query, $name)
	{
		return $query->where('country', 'like', '%'.$name.'%')
									->orWhere('destination', 'like', '%'.$name.'%');
	}

}
