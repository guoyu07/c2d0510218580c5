<?php

namespace App;

use App\Notifications\BackendResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\CommonApp\IndicationModel;
use App\Traits\CallTrait;


class Backend extends Authenticatable
{
	use Notifiable, CallTrait;

	protected $connection = 'mysql1';
	protected $appends = ['fullname', 'profile_pic'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'firstname','lastname', 'mobile', 'email', 
		'password', 'type', 'is_active', 'creator',
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
		$this->notify(new BackendResetPassword($token));
	}

	
	public function getFullnameAttribute()
	{
		return $this->attributes['firstname'] .' '.$this->attributes['lastname'];
	}


	public function getProfilePicAttribute()
	{
		return urlImage($this->attributes['image_path']);
	}

	public function findByEmailOrFail($email)
	{
		return $this->where(['email' => $email])->firstOrFail();
	}


	public function status()
	{   
		return $this->belongsTo(IndicationModel::class, 'is_active');
	}


	public function users()
	{
		$users = new Backend;
		if ($this->type == 'su') {
			$users = $users->all();
		}
		return $users;
	}



	public function activate()
	{
		if (isset($this->id) && $this->is_active != 3) {
			$this->is_active = 1;
			$this->save();
			session()->flash('success', 'User activated');
		}
		else{
			session()->flash('warning', 'Verification pending.');
		}
		return $this;
	}


	public function suspend()
	{
		if (isset($this->id) && $this->is_active != 3) {
			$this->is_active = 2;
			$this->save();
			session()->flash('danger', 'User suspended');
		}
		else{
			session()->flash('warning', 'Verification pending.');
		}
		return $this;
	}
}
