<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;

class VoucherModel extends Model
{
	use CallTrait;

	protected $table = 'vouchers';
	protected $appends = ['uid', 'status', 'voucher_url'];
	protected $casts = ['guests' => 'array', 'data' => 'array'];
	protected $dates = [
				'check_in',
				'check_out',
        'created_at',
        'updated_at',
    ];

	public function getUidAttribute()
	{
		return auth()->user()->admin->prefix
						.str_pad($this->id, 7, '0', STR_PAD_LEFT);
	}

	public function getTypeAttribute($value)
	{
		return proper($value);
	}


	public function getStatusAttribute()
	{
		return $this->is_active ? "Active" : "Inactive";
	}


	public function getVoucherUrlAttribute()
	{
		return route('vouchers.showPDF', $this->token);
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
