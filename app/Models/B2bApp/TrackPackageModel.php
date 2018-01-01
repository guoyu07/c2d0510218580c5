<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;

class TrackPackageModel extends Model
{
	use CallTrait;

	protected $table = 'track_packages';
	protected $appends = ['stay_time'];
	
	public function package()
	{
		return $this->belongsTo('App\Models\B2bApp\PackageModel', 'package_id');
	}


	public function scopeByUser($query)
	{
		return $query->whereHas('package', function($q) {
										$q->byUser();
									});
	}

	public function getStayTimeAttribute()
	{
		return convertSeconds($this->time_duration,false);
	}


	public function fatchTracks($take = 25)
	{
		return $this->byUser()->orderBy('id', 'desc')
														->simplePaginate($take);
	}

	
	public function activeTracks($skip = 0, $take = 25)
	{
		return $this->where(['status' => 1])
									->with('package')
										->whereHas('package', function($q) {
													$q->where('user_id','=', auth()->user()->id);
												})
											->skip($skip)
												->take($take)
													->get();
	}
}
