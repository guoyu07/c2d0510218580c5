<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class PackageServicePropertyModel extends Model
{
	protected $table = 'package_service_properties';
	protected $appends = ['ukey', 'details', 'vendor', 'property_name'];
	protected $vendorModelsClass = [
						'a' 	=> 'App\Models\HotelApp\AgodaHotelRoomModel',
						'b' 	=> 'App\Models\HotelApp\BookingHotelRoomModel',
						'own' => 'App\Models\HotelApp\OwnHotelRoomModel'
					];

	public function getUkeyAttribute()
	{
		return $this->property_id.'_'.$this->vendor;
	}

	public function getDetailsAttribute()
	{
		return [
			'id' => $this->id,
			'ukey' => $this->ukey,
			'no_of_rooms' => $this->no_of_rooms,
			'property_id' => $this->property_id,
			'vendor' => $this->vendor
		];
	}

	public function getPropertyNameAttribute()
	{
		return isset($this->property->name)
				 ? $this->property->name
				 : null;
	}


	public function getVendorAttribute()
	{
		return collect($this->vendorModelsClass)
						->flip()->get($this->property_type);
	}


	public function getRelatedModelNames($vendor='')
	{
		return collect($this->vendorModelsClass)->get($vendor);
	}

	public function packageService()
	{
		return $this->belongsTo(
										'App\Models\B2bApp\PackageServiceModel', 
										'package_service_id'
									);
	}

	public function property()
	{
		return $this->morphTo();
	}

}
