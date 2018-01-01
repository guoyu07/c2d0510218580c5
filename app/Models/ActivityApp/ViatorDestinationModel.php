<?php

namespace App\Models\ActivityApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;
use DB;

class ViatorDestinationModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql6';
	protected $table = 'viator_destinations';


	public function scopeByName($query, $name)
	{
		return $query->where('destinationName', $search)
									->orWhere('destinationName', 'LIKE' , $search);
	}


	public function activities()
	{
		return $this->hasMany('App\Models\BackendApp\ViatorActivityModel', 'primaryDestinationId', 'destinationId');
	}



	public function findByLatLong($lat, $long)
	{
		$distance = DB::raw('3956 * 2 * ASIN(SQRT( POWER(SIN(('.$lat.' - latitude)*pi()/180/2),2) + COS('.$lat.'*pi()/180 )*
			COS(latitude*pi()/180)*POWER(SIN(('.$long.' - longitude)
			*pi()/180/2),2))) as distance, \'v\' as vendor');

		$columns = ['*', $distance];

		$whereRaw = 'longitude between ('.$long.'-25/cos(radians('.$lat.'))*69) 
			and ('.$long.'+25/cos(radians('.$lat.'))*69) 
			and latitude between ('.$lat.'-(25/69)) 
			and ('.$lat.'+(25/69))';

		$result =  $this->select($columns)
											->whereRaw($whereRaw)
												->having('distance', '<', 20)
													->orderBy('distance', 'asc')
														->first();
		return $result;
	}

}
