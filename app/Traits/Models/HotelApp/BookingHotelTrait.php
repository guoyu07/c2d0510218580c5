<?php 

namespace App\Traits\Models\HotelApp;
use DB;

trait BookingHotelTrait 
{

	/*
	| params = [
	|				'latitude' => '', 
	|				'longitude' => '', 
	|				'max_rating' => ''
	|				'min_rating' => ''
	| 	];
	*/
	public function hotelsByLatLong(Array $params)
	{
		$params = (object) $params;
		$lat = $params->latitude;
		$long = $params->longitude;
		$maxRating = $params->max_rating == '' ? $params->max_rating : 5;
		$minRating = $params->min_rating == '' ? $params->min_rating : 0;
		$name = $params->name;

		$distance = DB::raw('3956 * 2 * ASIN(SQRT( POWER(SIN(('.$lat.' - latitude)*pi()/180/2),2) + COS('.$lat.'*pi()/180 )*
			COS(latitude*pi()/180)*POWER(SIN(('.$long.' - longitude)
			*pi()/180/2),2))) as distance, \'b\' as vendor');


		$columns = [
				'id', 'name', 'class as star_rating', 'longitude', 'latitude', $distance, 
				'address', 'zip', 'city_hotel', 'cc1', 
				'desc_en as description', 'photo_url as image'
			];

		$whereRaw = 'longitude between ('.$long.'-25/cos(radians('.$lat.'))*69) 
			and ('.$long.'+25/cos(radians('.$lat.'))*69) 
			and latitude between ('.$lat.'-(25/69)) 
			and ('.$lat.'+(25/69)) and class > '.$minRating.' and class < '.$maxRating;

		$result = $this->select($columns)
										->where([['name', 'like', '%'.$name.'%']])
											->whereRaw($whereRaw)
												->having('distance', '<', 20)
													->orderBy('star_rating', 'desc')
														->orderBy('distance', 'asc')
															->skip(0)
																->take(50)
																	->get();
		return $result;
	}


	public function hotelByCode($code)
	{
		$columns = [
				'id', 'name', 'class as star_rating', 'longitude', 'latitude',  
				'address', 'zip', 'city_hotel', 'cc1', 
				'desc_en as description', 'photo_url as image'
			];

		$result = $this->select($columns)
										->where(['id' => $code])
											->get();
		return $result;
	}

	/*
	| this function is to get activities from self db or cache data 
	| which is stored from other api like viator 
	| params = ["fgf_city_id" => 15180, "viator_city_id" => 10];
	*/	
	public function unionSearchHotels($params)
	{
		$params = (object) $params;
		$name = $params->name;
		$lat = $params->latitude;
		$long = $params->longitude;
		$maxRating = $params->max_rating == '' ? $params->max_rating : 5;
		$minRating = $params->min_rating == '' ? $params->min_rating : 0;

		$bookingSql = DB::raw('3956 * 2 * ASIN(SQRT( POWER(SIN(('.$lat.' - latitude)*pi()/180/2),2) + COS('.$lat.'*pi()/180 )*
			COS(latitude*pi()/180)*POWER(SIN(('.$long.' - longitude)
			*pi()/180/2),2))) as distance, 
			\'b\' as vendor, 
			CONCAT(address, \', \', city_hotel, \'-\', zip, 
				(SELECT country FROM trawish_api.destinations WHERE trawish_api.destinations.country_code = cc1 limit 1)) as address');


		$bookingColumns = [
				'id', 'name', 'class as star_rating', 'longitude', 'latitude',
				$bookingSql, 'desc_en as description', 'photo_url as image'
			];


		$agodaSql = DB::raw('3956 * 2 * ASIN(SQRT( POWER(SIN(('.$lat.' - latitude)*pi()/180/2),2) + COS('.$lat.'*pi()/180 )*
			COS(latitude*pi()/180)*POWER(SIN(('.$long.' - longitude)
			*pi()/180/2),2))) as distance, \'a\' as vendor,
			CONCAT(address, \', \', city, \'-\', 
			zipcode, \', \', country) as address');

		$agodaColumns = [
				'hotel_id as id', 'hotel_name as name', 'star_rating', 
				'longitude', 'latitude', $agodaSql, 'overview as description', 
				'photo1 as imags'
			];

		$bwhereRaw = 'longitude between ('.$long.'-25/cos(radians('.$lat.'))*69) 
			and ('.$long.'+25/cos(radians('.$lat.'))*69) 
			and latitude between ('.$lat.'-(25/69)) 
			and ('.$lat.'+(25/69)) 
			and name like \'%'.$name.'%\'
			and class > '.$minRating.' 
			and class < '.$maxRating;

		$awhereRaw = 'longitude between ('.$long.'-25/cos(radians('.$lat.'))*69) 
			and ('.$long.'+25/cos(radians('.$lat.'))*69) 
			and latitude between ('.$lat.'-(25/69)) 
			and ('.$lat.'+(25/69)) 
			and hotel_name like \'%'.$name.'%\'
			and star_rating > '.$minRating.' 
			and star_rating < '.$maxRating;


		$agoda = DB::connection('mysql4')->table('agoda_hotels')
								->select($agodaColumns)
									->whereRaw($awhereRaw);

		$booking = DB::connection('mysql4')->table('booking_hotels')
									->select($bookingColumns)
										->whereRaw($bwhereRaw)
											->unionAll($agoda)
												->having('distance', '<', 20)
													->orderBy('star_rating', 'desc')
														->orderBy('distance', 'asc')
															->offset(0)
		      											->limit(10)
																	->get();
		return $booking;
	}


	public function unionSearchHotelName($params)
	{
		$params = (object) $params;
		$name = $params->name;
		$lat = $params->latitude;
		$long = $params->longitude;
		$maxRating = $params->max_rating == '' ? $params->max_rating : 5;
		$minRating = $params->min_rating == '' ? $params->min_rating : 0;

		$bookingSql = DB::raw('3956 * 2 * ASIN(SQRT( POWER(SIN(('.$lat.' - latitude)*pi()/180/2),2) + COS('.$lat.'*pi()/180 )*
			COS(latitude*pi()/180)*POWER(SIN(('.$long.' - longitude)
			*pi()/180/2),2))) as distance');

		$bookingColumns = ['id', 'name', $bookingSql];

		$agodaSql = DB::raw('3956 * 2 * ASIN(SQRT( POWER(SIN(('.$lat.' - latitude)*pi()/180/2),2) + COS('.$lat.'*pi()/180 )*
			COS(latitude*pi()/180)*POWER(SIN(('.$long.' - longitude)
			*pi()/180/2),2))) as distance');

		$agodaColumns = ['hotel_id as id', 'hotel_name as name', $agodaSql];

		$bookingWhereRaw = 'longitude between ('.$long.'-25/cos(radians('.$lat.'))*69) 
			and ('.$long.'+25/cos(radians('.$lat.'))*69) 
			and latitude between ('.$lat.'-(25/69)) 
			and ('.$lat.'+(25/69)) 
			and name like \'%'.$name.'%\'';

		$agodaWhereRaw = 'longitude between ('.$long.'-25/cos(radians('.$lat.'))*69) 
			and ('.$long.'+25/cos(radians('.$lat.'))*69) 
			and latitude between ('.$lat.'-(25/69)) 
			and ('.$lat.'+(25/69)) 
			and hotel_name like \'%'.$name.'%\'';


		$agoda = DB::connection('mysql4')->table('agoda_hotels')
								->select($agodaColumns)
									->whereRaw($agodaWhereRaw);

		$booking = DB::connection('mysql4')->table('booking_hotels')
									->select($bookingColumns)
										->whereRaw($bookingWhereRaw)
											->unionAll($agoda)
												->having('distance', '<', 20)
													->groupBy('name')
														->orderBy('distance', 'asc')
															->offset(0)
		      											->limit(10)
																	->toSql();
		$result = [];
		foreach ($booking as $bookingValue) {
			$result[$bookingValue->name] = $bookingValue->name;
		}
		$result = array_values($result);
		return $result;
	}


	

	/*
	| this function is not used but it is for observe
	*/
	
	public function hotelByRawQuery($lat, $long)
	{
		$sqlQuery = "SELECT city_id, name, city_hotel, city_unique, latitude, longitude,
			3956 * 2 * 
			ASIN(SQRT( POWER(SIN(($lat - latitude)*pi()/180/2),2)
			+COS($lat*pi()/180 )*COS(latitude*pi()/180)
			*POWER(SIN(($long - longitude)*pi()/180/2),2))) 
			as distance 
		FROM booking_hotels 
		WHERE 
			longitude between ($long-25/cos(radians($lat))*69) 
			and ($long+25/cos(radians($lat))*69) 
			and latitude between ($lat-(25/69)) 
			and ($lat+(25/69)) 
			having distance < 20 
		ORDER BY distance 
		limit 50";
	
		$result = DB::connection($this->connection)->select(DB::raw($sqlQuery));
		return $result;
	}


}
