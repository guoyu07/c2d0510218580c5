<?php

namespace App\Models\TravelerApp;

use Illuminate\Database\Eloquent\Model;

class MyBookingModel extends Model
{
	protected $connection = 'mysql9';
	protected $table = 'my_bookings';


	public function scopeByToken($query, $token)
	{
		return $query->where('token', '=', $token);
	}


	public function bookedTo()
	{
		return $this->morphTo();
	}


	public function openUrl()
	{
		return route('traveler.booking.detail', $this->token);
	}


	public function voucherUrl()
	{
		return route('traveler.booking.voucher', $this->token);
	}


	public function cancelUrl()
	{
		return route('traveler.booking.cancel', $this->token);
	}



	protected static function boot()
	{
		parent::boot();

		static::creating(function ($model){
			$model->traveler_id = auth()->guard('traveler')->user()->id;
			$model->token = new_token();
		});

	}

}
