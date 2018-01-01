<?php 

namespace App\Traits;

trait GuardTrait 
{
	public function getProfilePicAttribute()
	{
		return is_null($this->image)
				 ? urlDefaultImageProfile()
				 : $this->image->url;
	}


	public function getFullnameAttribute()
	{
		return $this->attributes['firstname'] .' '.$this->attributes['lastname'];
	}

}
