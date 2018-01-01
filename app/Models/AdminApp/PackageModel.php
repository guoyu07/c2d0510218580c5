<?php

namespace App\Models\AdminApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\BackendApp\PlanModel;
use Carbon\Carbon;

class PackageModel extends Model
{
	protected $connection = 'mysql3';
	protected $table = 'packages';
	protected $appends = ['is_active'];


	public function getStartDateAttribute()
	{
		return Carbon::parse($this->attributes['start_date']);	
	}


	public function getEndDateAttribute()
	{
		return Carbon::parse($this->attributes['end_date']);	
	}

	public function getIsActiveAttribute()
	{ 
		$now = Carbon::now();
		return $this->end_date->gte($now);
	}

	public function plan()
	{
		return $this->belongsTo(PlanModel::class, 'plan_id');
	}

}
