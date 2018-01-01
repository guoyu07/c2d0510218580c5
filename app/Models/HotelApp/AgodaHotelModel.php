<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;
use DB;

class AgodaHotelModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql4';
	protected $table = 'agoda_hotels';
	protected $appends = [
								'vendor', 'code', 'name', 'built_data', 
								'image', 'description'
							];
	protected $hidden = [
								'addressline1', 'addressline2', 'zipcode', 
								'distance','photo1', 'photo2', 'photo3', 
								'photo4', 'photo5'
							];

	protected $searchColumnName = 'hotel_name';

	public function getVendorAttribute()
	{
		return 'a';
	}


	public function getCodeAttribute()
	{
		return $this->hotel_id;
	}

	public function getNameAttribute()
	{
		return $this->hotel_name;
	}


	public function getImageAttribute()
	{
		return $this->photo1;
	}

	public function getAddressAttribute($value)
	{
		$value = $value.', '.$this->city.' - '.
							$this->zipcode.', '.$this->country;
		$value = str_replace([', ,', ' - ,'], [',', ','], $value);

		return $value;
	}


	public function getDescriptionAttribute()
	{
		return $this->overview;
	}


	public function getBuiltDataAttribute()
	{
		return collect([
					'id' => $this->id,
					'code' => $this->code,
					'name' => $this->name,
					'city' => $this->city,
					'image' => $this->image,
					'images' => $this->images(),
					'vendor' => $this->vendor,
					'address' => $this->address,
					'country' => $this->country,
					'latitude' => $this->latitude,
					'longitude' => $this->longitude,
					'description' => $this->description,
					'star_rating' => $this->star_rating
				]);
	}	

	public function hotelsByLatLong(Array $params)
	{
		$params = (object) $params;
		$name = $params->name;
		$lat = $params->latitude;
		$long = $params->longitude;
		$maxRating = $params->max_rating == '' ? $params->max_rating : 5;
		$minRating = $params->min_rating == '' ? $params->min_rating : 0;

		$rawQuery = DB::raw('3956 * 2 * ASIN(SQRT( POWER(SIN(('.$lat.' - latitude)*pi()/180/2),2) + COS('.$lat.'*pi()/180 )*
			COS(latitude*pi()/180)*POWER(SIN(('.$long.' - longitude)
			*pi()/180/2),2))) as distance, \'a\' as vendor');

		$columns = [
				'hotel_id as id', 'hotel_name as name', 'star_rating', 
				'longitude', 'latitude', $rawQuery, 'address', 'zipcode', 'city', 'country', 
				'photo1 as image', 'overview as description'
			];

		$whereRaw = 'longitude between ('.$long.'-25/cos(radians('.$lat.'))*69) 
			and ('.$long.'+25/cos(radians('.$lat.'))*69) 
			and latitude between ('.$lat.'-(25/69)) 
			and ('.$lat.'+(25/69)) and star_rating > '.$minRating.' and star_rating < '.$maxRating;

		$result = $this->select($columns)
										->where([['hotel_name', 'like', '%'.$name.'%']])
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
				'hotel_id as id', 'hotel_name as name', 'star_rating', 
				'longitude', 'latitude', 'address', 'zipcode', 'city', 'country', 
				'photo1 as image', 'overview as description'
			];

		$result = $this->select($columns)
										->where(['hotel_id' => $code])
											->get();
		return $result;
	}

	public function hotelsByCityId($cityId, $index = 0, $take = 50, $isCol = true)
	{
		$columns = [
				'id', 'hotel_name as name', 'star_rating', 'longitude', 'latitude', 
				'addressline1', 'addressline2', 'zipcode', 'city', 'country', 
				'photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'overview as description'
			];

		if (!$isCol) {
			$columns = '*';
		}

		$result = $this->select($columns)
										->skip($index*$take)->take($take)
										 ->where([['city_id', '=', $cityId]])
										 	->get();
		return ($result);
	}


	public function searchHotelByName($cityId, $name, $index = 0, $take = 1, $isCol=true)
	{
		$columns = [
				'id', 'hotel_id', 'hotel_name', 'star_rating', 'longitude', 'latitude', 
				'checkin', 'checkout', 'addressline1', 'addressline2', 'zipcode', 
				'city', 'country', 'photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'overview'
			];

		/*if not true*/
		if (!$isCol) {
			$columns = '*';
		}

		$result = $this->select($columns)
										->skip($index*$take)->take($take)
										 ->where([
										 			['city_id', '=', $cityId], 
										 			['hotel_name', '=', $name]
										 		])
										 	->get();
		return ($result);
	}


	public function searchHotelsByName($cityId, $name, $index = 0, $take = 10, $isCol = true)
	{
		$columns = ['hotel_name'];

		/*if not true*/
		if (!$isCol) {
			$columns = '*';
		}

		$result = $this->select($columns)
										->skip($index*$take)->take($take)
										 ->where([
										 			['city_id', '=', $cityId], 
										 			['hotel_name', 'like', '%'.$name.'%']
										 		])
										 	->get();
		return ($result);
	}


	public function hotelsByCity($city, $isCol = true)
	{
		$columns = [
				'id', 'hotel_id', 'hotel_name', 'star_rating', 'longitude', 'latitude', 
				'checkin', 'checkout', 'addressline1', 'addressline2', 'zipcode', 
				'city', 'country', 'photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'overview'
			];

		if (!$isCol) {
			$columns = '*';
		}

		return $this->select($columns)->where([['city', 'like', '%'.$city.'%']])->get();
	}

	/*
	| this function is to get hotel detail by hotels id
	*/
	public function hotelByAgodaId($agodaHotelId)
	{
		return $this->select()->where(['hotel_id' => $agodaHotelId])->first();
	}


	public function hotelDetail()
	{
		return $this->hasOne(
											'App\Models\HotelApp\AgodaHotelDetailModel', 
											'hotel_id', 'hotel_id'
										);
	}

	public function hotelImages()
	{
		return $this->hasMany(
											'App\Models\HotelApp\AgodaHotelImageModel', 
											'hotel_id', 'hotel_id'
										);
	}
	

	public function images()
	{
		// $result = $this->hotelImages;

		$images = [];
		$images[] = $this->photo1; 
		$images[] = $this->photo2; 
		$images[] = $this->photo3; 
		$images[] = $this->photo4; 
		$images[] = $this->photo5;		

		/*if ($result->count()) {
			foreach ($result as $hotelImage) {
				$images[] = $hotelImage->LocationWithSquareSize2X;
			}
		}*/
		return $images;
	}

}
