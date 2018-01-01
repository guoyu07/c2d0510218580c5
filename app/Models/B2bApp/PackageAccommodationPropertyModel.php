<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class PackageAccommodationPropertyModel extends Model
{
	protected $table = 'package_accommodation_properties';
	protected $appends = ['built_data', 'vendor'];


	public function getVendorAttribute()
	{
		$modelNames = [
				'App\Models\HotelApp\AgodaHotelRoomModel' => 'a',
				'App\Models\HotelApp\BookingHotelRoomModel' => 'b',
				'App\Models\HotelApp\TboHotelRoomModel' => 'tbo',
			];

		return collect($modelNames)->get($this->accommodation_type);
	}


	public function getBuiltDataAttribute()
	{
		$data = is_null($this->property)
			? collect()
			: $this->property->built_data;

		$data->put('package_accommodation_property_id', $this->id);
		return $data;
	}


	public function getVendorModelName($vendor)
	{
		$models = [
						'a' => 'App\Models\HotelApp\AgodaHotelRoomModel',
						'b' => 'App\Models\HotelApp\BookingHotelRoomModel',
						'tbo' => 'App\Models\HotelApp\TboHotelRoomModel',
						'ctt' => 'App\Models\CruiseApp\CruiseCabinModel',
					];

		return array_get($models, $vendor, null);
	}


	public function packageAccommodation()
	{
		return $this->belongsTo(
											'App\Models\B2bApp\PackageAccommodationModel',
											'package_accommodation_id'
										);
	}



	public function property()
	{
		return $this->morphTo();
	}

}
