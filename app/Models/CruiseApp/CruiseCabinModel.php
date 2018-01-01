<?php

namespace App\Models\CruiseApp;

use Illuminate\Database\Eloquent\Model;

class CruiseCabinModel extends Model
{
	protected $connection = 'mysql5';
	protected $table = 'cruise_cabins';
	protected $appends = ['vendor', 'cabintype', 'built_data'];
	protected $hidden = ['vendor_detail_id', 'created_at', 'updated_at'];


	public function getVendorAttribute()
	{
		$models = [
					'App\Models\CruiseApp\CttCruiseModel' => 'ctt',
				];
		return array_get($models, $this->cruise_type, 'f');
	}


	public function getCabinTypeAttribute()
	{
		return $this->cabin_code.'-'.$this->cabin;
	}


	public function getBuiltDataAttribute()
	{
		return collect([
				'id' => $this->id,
				'cabintype' => $this->cabin,
				'property_type' => $this->cabin,
				'vendor' => $this->vendor
			]);
	}


	public function vendorDetail()
	{
		return $this->belongsTo('App\Models\CruiseApp\VendorDetailModel', 'vendor_detail_id');
	}


	public function cruise()
	{
		return $this->morphTo();
	}



}
