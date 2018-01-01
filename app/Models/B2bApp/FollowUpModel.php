<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class FollowUpModel extends Model
{
	protected $table =  'follow_ups';
	protected $appends = ['status'];

	public function getStatusAttribute()
	{
		return is_null($this->indication) ? '' : $this->indication->name;
	}


	public function scopeByUser($query)
	{
		$auth = auth()->user();
		return $query->where('user_id', $auth->id);
	}

	public function scopeByIsActive($query, $isActive = 1)
	{
		return $query->where('is_active', $isActive);
	}


	public function scopeBySearch($query, $name)
	{
		return $query->whereHas('package', function ($q) use ($name){
								$q->whereHas('client', function ($q) use ($name){
										$q->where('fullname', 'like', '%'.$name.'%');
									});
							});
	}

	public function scopeByGtNow($query)
	{
		return $query->whereRaw("`datetime` > now()");
	}


	public function package()
	{
		return $this->belongsTo('App\Models\B2bApp\PackageModel', 'package_id');
	}

	public function indication()
	{
		return $this->belongsTo('App\Models\CommonApp\IndicationModel', 'is_active');
	}


}
