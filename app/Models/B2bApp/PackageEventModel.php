<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class PackageEventModel extends Model
{
	protected $table = 'package_events';
	protected $appends = ['event_url'];

	public function setTokenAttribute()
	{
		$this->attributes['token'] = new_token();
	}


	public function getEventUrlAttribute()
	{
		return url('dashboard/package/builder/'.$this->event.'/'.$this->package->token);
	}


	public function eventActionUrl()
	{
		return url('dashboard/package/builder/event/'.$this->package->token.'/'.$this->token);
	}


	public function scopeByToken($query, $token)
	{
		return $query->where('token', $token);
	}

	public function scopeByPackageId($query, $packageId)
	{
		return $query->where('package_id', $packageId);
	}

	public function scopeByEvent($query, $event)
	{
		return $query->where('event', $event);
	}


	public function package()
	{
		return $this->belongsTo('App\Models\B2bApp\PackageModel', 'package_id');
	}


	public function copyEvent($pid)
	{
		$newEvent = new PackageEventModel;
		
		if ($this->id) {
			$newEvent->package_id = $pid;
			$newEvent->event = $this->event;
			$newEvent->is_active = $this->is_active;
			$newEvent->save();
		}

		return $newEvent;
	}


	public function __construct(array $attributes = [])
	{
		$this->setTokenAttribute();
		parent::__construct($attributes);
	}


}
