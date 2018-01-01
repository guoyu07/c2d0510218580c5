<?php 

namespace App\Traits\Models\HotelApp;
use DB;

trait CoordinateTrait 
{
	protected $traitDistance = 50;

	public function scopeByLatLong($query, $lat, $long)
	{
		$distance = DB::raw('SQRT( POW(69.1 * (latitude - '.$lat.'), 2) + POW(69.1 * ('.$long.' - longitude) * COS(latitude / 57.3), 2)) AS distance');

		return $query->addSelect($distance)
									->having('distance', '<', $this->traitDistance);
	}



	public function scopeByLatLongOld($query, $lat, $long)
	{

		$col = DB::raw('3956 * 2 * ASIN(SQRT( POWER(SIN(('.$lat.' - latitude)*pi()/180/2),2) + COS('.$lat.'*pi()/180 )*
			COS(latitude*pi()/180)*POWER(SIN(('.$long.' - longitude)
			*pi()/180/2),2))) as distance, CONCAT(TRUNCATE(latitude,3), \'_\', TRUNCATE(longitude,3)) as lat_long');

		$whereRaw = 'longitude between ('.$long.'-25/cos(radians('.$lat.'))*69) 
			and ('.$long.'+25/cos(radians('.$lat.'))*69) 
			and latitude between ('.$lat.'-(25/69)) 
			and ('.$lat.'+(25/69))';

		return $query->addSelect($col)
										->whereRaw($whereRaw)
											->having('distance', '<', $this->traitDistance)
												->groupBy('lat_long');


	}

}
