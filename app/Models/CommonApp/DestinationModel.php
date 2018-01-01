<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\CommonApp\GoogleMapController;
use App\Models\ActivityApp\ViatorDestinationModel;
use App\Models\HotelApp\TbtqDestinationModel;
use App\Models\CommonApp\IndicationModel;
use App\Models\CommonApp\ImagesModel;
use App\Traits\CallTrait;
use DB;

class DestinationModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql2';
	protected $table = 'destinations';
	protected $casts = ['geocode' => 'object'];
	protected $appends = [
								'location', 'echo_location', 'viator_destination',
								'tbo_destination'
							];
	protected $hidden = ['created_at', 'updated_at'];


	public function getLatitudeAttribute($value)
	{
		if (is_null($value)) {
			$value = $this->pullGeocode();
			$value = isset($value->results[0]->geometry->location->lat)
						 ? $value->results[0]->geometry->location->lat 
						 : null;
		}

		return $value;
	}
	

	public function getLongitudeAttribute($value)
	{
		if (is_null($value)) {
			$value = $this->pullGeocode();
			$value = isset($value->results[0]->geometry->location->lng)
						 ? $value->results[0]->geometry->location->lng 
						 : null;
		}

		return $value;
	}

	public function getGeocodeAttribute($value)
	{
		if (is_null($value)) {
			$value = $this->pullGeocode();
		}
		else{
			$value = json_decode($value);
		}

		return $value;
	}


	public function getLocationAttribute()
	{
		$country = isset($this->attributes['country']) 
						 ? $this->attributes['country']
						 : '';

		$destination = isset($this->attributes['destination']) 
						 ? $this->attributes['destination']
						 : '';

		return echoLocation($destination, $country);
	}


	public function getEchoLocationAttribute()
	{
		$country = isset($this->attributes['country']) 
						 ? $this->attributes['country']
						 : '';

		$destination = isset($this->attributes['destination']) 
						 ? $this->attributes['destination']
						 : '';

		return echoLocation($destination, $country, '-');
	}



	public function getViatorDestinationAttribute()
	{
		$result = $this->findViatorDestination;
		
		if (is_null($result)) {
			$result = ViatorDestinationModel::call()
								->findByLatLong($this->latitude, $this->longitude);
		}

		return $result;		
	}



	public function getTboDestinationAttribute()
	{
		return TbtqDestinationModel::byCountryCode($this->country_code)
																->byDestination($this->destination)
																	->first();	
	}


	public function scopeBySearch($query, $name)
	{
		return $this->where('destination', 'like', $name.'%')
									->orWhere('country', 'like', $name.'%');
										// ->orWhere('destination', 'like', '%'.$name.'%')
										// 	->orWhere('country', 'like', '%'.$name.'%');
	}


	public function scopeByTag($query, $tag)
	{
		if (!is_null($tag)) {
			return $query->where('tags', 'like', '%'.$tag.'%');
		}
	}


	public function status()
	{
		return $this->belongsTo(IndicationModel::class, 'is_active');
	}


	public function countryDetail()
	{
		return $this->belongsTo(
				'App\Models\CommonApp\CountryModel', 
				'country_code', 'country_code'
			);
	}



	public function images()
	{
		$result = $this->morphMany(ImageModel::class, 'connectable');
		return $result->where('is_active', 1);
	}


	public function pullGeocode()
	{
		$value = GoogleMapController::call()->geoCode($this->location);

		if (isset($value->results[0]->geometry->location->lat) && isset($value->results[0]->geometry->location->lng)) {
			$this->latitude = $value->results[0]->geometry->location->lat;
			$this->longitude = $value->results[0]->geometry->location->lng;
			$this->geocode = $value;
			$this->save();
		}

		return $value;
	}



	public function getLocation($search, $tags = null){
		$isTag = $tags == null ? '' : "AND tags LIKE '%$tags%'";
		$where = "CONCAT(`destination`, ', ', `country`) LIKE '%$search%' $isTag";
		$result = $this->select()->whereRaw($where)->get();
		return  $result;
	}


	public function getLocationRight($search, $tags = null){
		$isTag = $tags == null ? '' : "AND tags LIKE '%$tags%'";
		$where = "CONCAT(`destination`, ', ', `country`) LIKE '$search%' $isTag";
		$result = $this->select()->whereRaw($where)->get();
		return  $result;
	}



	public function visaDetail()
	{
		return $this->hasOne('App\Models\CommonApp\VisaDetailModel', 'country', 'country');
	}


	public function search($value)
	{
		return $this->select()
									->where([
												['is_active', '=', 1], 
												[
													DB::raw("CONCAT(destination, ', ',  country)"), 
													'LIKE', '%'.$value.'%'
												]
											])
										->first();
	}

	// findByDestination use search insted of this


	public function searchName($value)
	{
		$result = $this->select(DB::raw("CONCAT(destination, ', ',  country) AS location"))
						->where([
									[$this->table.'.is_active', '=', 1], 
									[$this->table.'.destination', 'LIKE', '%'.$value.'%']
								])
						->get();

		return $result;
	}





	public function findViatorDestination()
	{
		$result = $this->hasOne(
												ViatorDestinationModel::class, 
												'destinationName', 'destination'
											);

		return $result->orWhere(
												'destinationName', 'like', 
												'%'.$this->destination.'%'
											);
	}



}
