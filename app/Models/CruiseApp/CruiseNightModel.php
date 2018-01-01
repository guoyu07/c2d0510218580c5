<?php

namespace App\Models\CruiseApp;

use Illuminate\Database\Eloquent\Model;

class CruiseNightModel extends Model
{
	protected $connection = 'mysql5';
	protected $table = 'cruise_nights';


	public function vendorDetail()
	{
		return $this->belongsTo('App\Models\CruiseApp\VendorDetailModel', 'vendor_detail_id');
	}

	public function cruiseOnlyDate()
	{
		return $this->hasOne(
											'App\Models\CruiseApp\CruiseOnlyDateModel', 
											'cruise_night_id'
										);
	}

}
