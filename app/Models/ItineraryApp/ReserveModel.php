<?php

namespace App\Models\ItineraryApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\B2bApp\PackageModel;

class ReserveModel extends Model
{
	protected $connection = 'mysql8';
	protected $table = 'reserves';

	public function package()
	{
		return $this->belongsTo(PackageModel::class, 'package_id');
	}

}
