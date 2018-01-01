<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class PackageCruiseCabinModel extends Model
{
	protected $table = 'package_cruise_cabins';

	public function getCabinIdAttribute()
	{
		return $this->cabintype_code;
	}

	public function getCabinTypeAttribute()
	{
		$model = '';
		if ($this->vendor == 'f') {
			$model = 'App\Models\CruiseApp\CruiseCabinModel';
		}
		return $model;
	}

	public function cabin()
	{
		return $this->morphTo();
	}

}
