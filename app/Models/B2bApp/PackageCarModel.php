<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class PackageCarModel extends Model
{
	protected $table = 'package_cars';
	protected $casts = [
				'request' => 'object',
			];


	public function setStatusAttribute($value)
	{
		$this->attributes['status'] = strtolower($value);
	}

	/*
	| this function is for getting package data 
	| from package table behalf of package_id
	*/
	public function package()
	{
		return $this->belongsTo('App\Models\B2bApp\PackageModel', 'package_id');
									// ->with('client'); // this might be not needed		
	}



	/*
	| this function is to get qpx flight 
	*/
	public function skyScannerCar()
	{
		return $this->belongsTo('App\Models\Api\SkyscannerCarModel', 'skyscanner_car_id');
	}
	
}
