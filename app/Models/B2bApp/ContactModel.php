<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;

class ContactModel extends Model
{
	use CallTrait;

	protected $table = 'contacts'; 

	public function setUserIdAttribute($value = null)
	{
		if (is_null($value)) {
			$auth = auth()->user();
			$value = $auth->id;
		}

		$this->attributes['user_id'] = $value;
	}

	// self_search >> findContacts
  public function findContacts($word){
  	$auth = auth()->user();
  	$query = "CONCAT(`title`, '', `fullname`, ' ', `phone`, ' ', `email`) LIKE '%$word%' AND `status` = 'Active' AND `user_id` = '".$auth->id."'";
  	$result = $this->whereRaw($query)->simplePaginate(9);
		return $result;
	}
}
