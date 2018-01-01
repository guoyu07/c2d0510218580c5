<?php

namespace App\Models\FlightApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;

class QpxLimitModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql7';
	protected $table = 'qpx_limits';


	public function todayCalled($key)
	{
		$date = date("Y-m-d");
		$keys = $this->where(['key' => $key])
										->whereRaw('date(`created_at`) = \''.$date."'")
											->get();
		return $keys;
	}
}
