<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommonApp\IndicationModel;
use App\Traits\CallTrait;
use Carbon\Carbon;
use DB;

class PackageActivityModel extends Model
{
	use CallTrait;

	protected $table  = 'package_activities';
	protected $appends = [
									'images', 'mode_name', 'description', 
									'activity_details', 'package_service_id'
								];
	protected $hidden = ['created_at', 'updated_at'];

	public function getImagesAttribute()
	{
		return $this->images();
	}

	public function getModeNameAttribute()
	{
		$mode = IndicationModel::byCategory('act_mode')
						->byKey($this->mode)->first();

		return isset($mode->name) 
				 ? $mode->name
				 : str_replace('_', ' ', $this->mode);
	}


	public function getTitleAttribute($value)
	{
		return strlen($value) ? $value : (isset($this->activity->title) 
 				 ? $this->activity->title
 				 : null);
	}


	public function getDescriptionAttribute()
	{
		$description = null;

		if (isset($this->descriptionModel->description)) {
			$description = $this->descriptionModel->description;
		}
		elseif (isset($this->activity->description)) {
			$description = $this->activity->description;
		}

		return clean_html($description);
	}


	public function getPickUpAttribute($value)
	{
		if (is_null($value) && isset($this->activity->pick_up) && strlen($this->activity->pick_up)) {
			$value = $this->activity->pick_up;
		}

		if (strlen($value) < 4) $value = '00:00:00';

		return $value;
	}


	public function getDurationAttribute($value)
	{
		if (is_null($value) && isset($this->activity->duration) && strlen($this->activity->duration)) {
			$value = $this->activity->duration;
		}

		if (strlen($value) < 4) $value = '00:00:00';

		return $value;
	}


	public function getPackageServiceIdAttribute()
	{
		return isset($this->packageService->id)
				 ? $this->packageService->id
				 : null;
	}


	public function getActivityDetailsAttribute()
	{
		$activity = $this->activity;
		$result = [];

		if (!is_null($activity)) {
			$result = [
					'id' => $this->id,
					'package_service_id' => $this->package_service_id,
					'ukey' => $activity->vendor.'_'.$activity->id,
					'code' => $activity->id,
					'vendor' => $activity->vendor,
					'image' => $this->images()->first(),
					'name' => $this->title,
					'description' => $this->description,
					'sort_description' => substr($this->description, 0, 750),
					'date' => $this->date,
					'timing' => $this->timing,
					'mode' => $this->mode,
					'mode_name' => $this->mode_name,
					'pick_up' => $this->pick_up,
					'duration' => $this->duration,
					'inclusion' => $activity->inclusion,
					'exclusion' => $activity->exclusion,
					'is_fullday' => $this->is_fullday,
					'is_morning' => $this->is_morning,
					'is_noon' => $this->is_noon,
					'is_evening' => $this->is_evening,
					'images' => $this->images()
				];
		}

		return collect($result);
	}


	public function scopeByIsActive($query, $bool = 1)
	{
		return $query->where('is_active', $bool);
	}


	public function scopeByRouteId($query, $id)
	{
		return $query->where('route_id', $id);
	}


	public function scopeByToken($query, $token)
	{
		$id = mydecrypt($token);
		return $query->where('id', $id);
	}


	public function route()
	{
		return $this->belongsTo('App\Models\B2bApp\RouteModel', 'route_id');
	}


	public function activity()
	{
		return $this->morphTo();
	}


	public function packageService()
	{
		return $this->morphOne('App\Models\B2bApp\PackageServiceModel', 'fusion');
	}



	public function descriptionModel()
	{
		return $this->belongsTo('App\Models\CommonApp\DescriptionModel', 'description_id');
	}




	public function activityObject($attribute = [])
	{
		$activity = $this->activity;
		if (!is_null($activity)) {
			$ukey = $activity->vendor.'_'.$activity->id;
			$name = $activity->title;
			$image = $activity->image_url;
			$description = $this->description;
			

			$pickUp = is_null($this->pick_up) 
							 ? $activity->pick_up 
							 : $this->pick_up;
			
			$duration = is_null($this->duration)
								? $activity->duration
								: $this->duration;


			$result = [
					'pdid' => $this->id,
					'ukey' => $ukey,
					'code' => $activity->id,
					'vendor' => $activity->vendor,
					'image' => $image,
					'name' => $name,
					'description' => $description,
					'sort_description' => substr($description, 0, 750),
					'date' => $this->date,
					'timing' => $this->timing,
					'mode' => $this->mode,
					'mode_name' => $this->mode_name,
					'isSelected' => 1,
					'pick_up' => $pickUp,
					'duration' => $duration,
					'inclusion' => $activity->inclusion,
					'exclusion' => $activity->exclusion,
				];


			if (in_array('images', $attribute)) {
				$result['images'] = $this->images()
														->push($result['image'])->unique();
			}

			return (object) $result;
		}
	}


	public function voucherData()
	{
		$data = $this->activityObject(['images']);
		$companyName = '-';
		$companyAddr = '-';
		$clientName = '';
		$pax = '';

		if (isset($this->route->package)) {
			$companyName = $this->route->package->user->admin->companyname;
			$companyAddr = $this->route->package->user->admin->address;
			$clientName = $this->route->package->client->fullname;
			$pax = $this->route->package->pax_detail;
		}

		$activity = (array) $this->activityObject();
		$activity['date'] = Carbon::parse($activity['date']); 
		$result = [
				"clientName" => $clientName,
				"companyName" => $companyName,
				"companyAddr" => $companyAddr,
				"pax" => $pax,
			];

		$result = array_merge($result,$activity);
		return (object)$result;
	}


	public function images()
	{

		$images = collect([]);
		if ($this->activity->vendor == 'v') {
			$images = $images->merge($this->activity->images);
		}
		else{
			$images = $images->merge($this->activity
													->images->pluck('url')
														->toArray());
		}
		
		$images = $images->filter(function($item){
			if (!is_null($item)) {
				return $item;
			}
		})->unique();
		return $images;
	}

}
