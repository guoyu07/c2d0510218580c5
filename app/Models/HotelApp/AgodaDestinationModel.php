<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;

class AgodaDestinationModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql4';
	protected $table = 'agoda_destinations';

	public function searchFirst($search){

		$result = $this->select()
										 ->where(['city' => $search])
											->first();

		if (is_null($result)) {
			$result = $this->select()
											->where('city', 'LIKE' , $search)
												->first();
		}
		
		return $result;
	}


	public function search($search){

		$result = $this->select()
										 ->where(['city' => $search])
											->get();

		if ($result->count() == 0) {
			$result = $this->select()
											->where('city', 'LIKE' , $search)
												->get();
		}
		
		return $result;
	}

}
