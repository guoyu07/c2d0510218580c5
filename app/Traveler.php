<?php

namespace App;

use App\Notifications\TravelerResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\GuardTrait;

class Traveler extends Authenticatable
{
	use Notifiable, GuardTrait;

	protected $connection = 'mysql9';
	protected $appends = ['fullname', 'profile_pic'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'firstname', 'lastname', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * Send the password reset notification.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new TravelerResetPassword($token));
	}


	public function image()
	{
		return $this->belongsTo('App\Models\CommonApp\ImageModel', 'image_id');
	}


	public function myBookings()
	{
		return $this->hasMany('App\Models\TravelerApp\MyBookingModel', 'traveler_id');
	}

}
