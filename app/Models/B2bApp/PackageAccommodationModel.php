<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class PackageAccommodationModel extends Model
{
	protected $table = 'package_accommodations';
	protected $appends = ['accommodation_details', 'vendor'];


	public function getVendorAttribute()
	{
		$modelNames = [
				'App\Models\HotelApp\AgodaHotelModel' 	 => 'a',
				'App\Models\HotelApp\BookingHotelModel'  => 'b',
				'App\Models\HotelApp\TbtqJsonHotelModel' => 'tbo',
				'App\Models\CruiseApp\CttCruiseModel'		 => 'ctt',
			];

		return collect($modelNames)->get($this->accommodation_type);
	}


	public function getAccommodationDetailsAttribute()
	{
		$details = collect();

		if ($this->vendor == 'tbo') {
			$details = $this->accommodation->builtDataByIndex($this->index);
		}
		elseif (in_array($this->vendor, ['a', 'b', 'ctt']) && isset($this->accommodation->built_data)) {
			$details = $this->accommodation->built_data;
		}

		if (!is_null($this->packageService)) {
			$details->put('package_service_id', $this->packageService->id);
		}

		$details->put('properties', $this->packageAccommodationProperties->pluck('built_data'));

		return $details;
	}


	public function accommodation()
	{
		return $this->morphTo();
	}


	public function packageAccommodationProperties()
	{
		return $this->hasMany(
				'App\Models\B2bApp\PackageAccommodationPropertyModel',
				'package_accommodation_id'
			);
	}


	public function packageService()
	{
		return $this->morphOne('App\Models\B2bApp\PackageServiceModel', 'fusion');
	}


	public function getVendorModelName($key)
	{
		$models = [
						'a' => 'App\Models\HotelApp\AgodaHotelModel',
						'b' => 'App\Models\HotelApp\BookingHotelModel',
						'tbo' => 'App\Models\HotelApp\TbtqJsonHotelModel',
						'ctt' => 'App\Models\CruiseApp\CttCruiseModel',
					];

		return array_get($models, $key);
	}


}
