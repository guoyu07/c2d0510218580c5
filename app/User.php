<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\CommonApp\IndicationModel;
use App\Models\B2bApp\UserIpModel;
use App\Traits\CallTrait;
use App\Admin;

class User extends Authenticatable
{
	use Notifiable, CallTrait;

	protected $connection = 'mysql';
	protected $table = 'users';
	protected $appends = [
								'fullname', 'profile_pic', 
								'indication', 'assign_to',
								'is_ip_found'
							];
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'admin_id','firstname','lastname','username', 
			'mobile', 'email', 'password', 'type', 'is_active'
		];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token',];


	
	public function getFullnameAttribute()
	{
		return $this->attributes['firstname'] .' '.$this->attributes['lastname'];
	}

	public function getProfilePicAttribute()
	{
		return urlImage($this->attributes['image_path']);
	}



	public function getIndicationAttribute()
	{
		return isset($this->status->name)
					 ? $this->status->name
					 : 'is in trouble please contact admin';
	}


	public function getIsIpFoundAttribute()
	{
		return boolval(UserIpModel::byIp()->count());
	}


	public function getAssignToAttribute()
	{
		return $this->fullname.' ('.$this->email.')';
	}


	public function scopeByEmail($query, $email)
	{
		return $query->where('email', $email);
	}


	public function status()
	{
		return $this->belongsTo(IndicationModel::class, 'is_active');
	}


	public function clients()
	{
		return $this->hasMany(
										'App\Models\B2bApp\ClientModel', 
										'user_id'
									);
	}


	public function admin()
	{
		return $this->belongsTo(Admin::class, 'admin_id');
	}


	public function userIps()
	{
		return $this->hasMany(UserIpModel::class, 'user_id')
									->skip(0)->take(50);
	}



	public function findByEmailOrFail($email)
	{
		$auth = auth()->guard('admin')->user();
		return $this->where([
												'email' => $email, 
												'admin_id' => $auth->id
											])
										->firstOrFail();
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
