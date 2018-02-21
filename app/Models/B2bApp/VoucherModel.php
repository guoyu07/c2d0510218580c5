<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;

class VoucherModel extends Model
{
	use CallTrait;

	protected $table = 'vouchers';
	protected $appends = ['uid', 'status', 'open_url'];


	public function getUidAttribute()
	{
		return auth()->user()->admin->prefix
						.str_pad($this->id, 7, '0', STR_PAD_LEFT);
	}



	public function getStatusAttribute()
	{
		return $this->is_active ? "Active" : "Inactive";
	}


	public function getOpenUrlAttribute()
	{
		return route('vouchers.show', $this->token);
	}



	public function scopeByUser($query)
	{
		return $query->where('user_id', auth()->user()->id);
	}


	public function scopeByToken($query, $token)
	{
		return $query->where('token', $token);
	}


	public function client()
	{
		return $this->belongsTo('App\Models\B2bApp\ClientModel', 'client_id');
	}

	public function voucherServices()
	{
		return $this->hasMany('App\Models\B2bApp\VoucherServiceModel', 'voucher_id');
	}

	public function user(){
		return $this->belongsTo('App\User', 'user_id');
	}


	protected static function boot()
	{
		parent::boot();
		
		static::creating(function($model){
			$auth = auth()->user();
			$model->token = str_random(32); // setting token
			$model->user_id = $auth->id;
		});
	}
}
