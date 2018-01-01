<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class UserIpModel extends Model
{
	protected $table = 'user_ips';

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}


	public function scopeByIp($query, $ip = null)
	{
		$ip = is_null($ip) ? getRemoteIp() : $ip;
		return $query->where('ip', $ip);
	}


	protected static function boot()
	{
		parent::boot();
		
		static::creating(function($model){
			$auth = auth()->user();
			$model->user_id= $auth->id;
			$model->ip =  getRemoteIp();
		});

	}

}
