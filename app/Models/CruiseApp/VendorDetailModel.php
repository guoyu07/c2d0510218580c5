<?php

namespace App\Models\CruiseApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;
use DB;

class VendorDetailModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql5';
	protected $table = 'vendor_details';
	protected $appends = ['uid'];


	public function getUidAttribute()
	{
		return $this->prefix.$this->id;
	}

	public function getCompanyNameAttribute($value)
	{
		return proper($value);
	}

	public function cruiseNights()
	{
		return $this->hasOne(
											'App\Models\CruiseApp\CruiseNightModel', 
											'vendor_detail_id'
										);
	}


	public function cabins()
	{
		$cabins = $this->hasMany(
											'App\Models\CruiseApp\CruiseCabinModel', 
											'vendor_detail_id'
										);

		return $cabins->orderBy('cabin_code', 'desc');
	}
	

	public function destination()
	{
		return $this->belongsTo(
											'App\Models\CommonApp\DestinationModel', 
											'destination_code'
										);
	}


	public function images()
	{
    return $this->morphMany('App\Models\CommonApp\ImageModel', 'connectable');
	}

	public function imagesAsArray()
	{
		$images = [];
		foreach ($this->images as $image) {
			$images[] = $image->url;
		}
		if (empty($images)) {
			$images[] = urlDefaultImageCruise();
		}
		return $images;
	}


}
