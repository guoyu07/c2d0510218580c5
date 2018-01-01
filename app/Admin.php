<?php

namespace App;

use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\AdminApp\LeadVendorModel;
use App\Models\AdminApp\PackageModel;
use App\Models\CommonApp\ImageModel;
use App\Models\AdminApp\TextModel;
use App\Traits\GuardTrait;
use App\User;

class Admin extends Authenticatable
{
	use Notifiable, GuardTrait;
	
	protected $connection = 'mysql3';
	protected $appends = ['fullname', 'profile_pic', 'logo', 'about'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'prefix', 'firstname','lastname', 
		'companyname', 'username', 'mobile',
		'email', 'password', 'type',
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
		$this->notify(new AdminResetPassword($token));
	}

	


	public function getLogoAttribute()
	{
		return is_null($this->imageLogo)
				 ? urlDefaultImageProfile()
				 : $this->imageLogo->url;
	}

	public function getProfilePicAttribute()
	{
		return is_null($this->imageProfile)
				 ? urlDefaultImageProfile()
				 : $this->imageProfile->url;
	}

	public function getAboutAttribute($value)
	{
		return is_null($this->textAbout) ? '' : $this->textAbout->text;
	}


	public function getBalanceAttribute($value)
	{
		return round($value, 2);
	}


	public function users()
	{
		return $this->hasMany(User::class, 'admin_id');
	}

	public function texts()
	{
		$result = $this->hasMany(TextModel::class, 'admin_id');
		
		return $result->where([
												'is_active' => 1 , 
												['id', '<>', $this->text_about_id]
											])
										->orderBy("order","asc");
	}

	public function leadVendors()
	{
		$result = $this->hasMany(LeadVendorModel::class, 'admin_id');
		return $result->where(['is_active' => 1]);
	}


	public function package()
	{
		return $this->belongsTo(PackageModel::class, 'package_id');
	}



	public function imageProfile()
	{
		return $this->belongsTo(ImageModel::class, 'image_profile_id');
	}


	public function imageLogo()
	{
		return $this->belongsTo(ImageModel::class, 'image_logo_id');
	}

	public function textAbout()
	{
		return $this->belongsTo(TextModel::class, 'text_about_id');
	}


	public function isPackageActive()
	{
		$result = false;
		if (!is_null($this->package) ) {
			$result = $this->package->is_active;
		}

		return $result;

	}

}
