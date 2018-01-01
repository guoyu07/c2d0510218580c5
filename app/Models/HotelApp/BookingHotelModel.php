<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\HotelApp\BookingHotelTrait;
use App\Traits\Models\HotelApp\CoordinateTrait;
use App\Traits\CallTrait;
use DB;

class BookingHotelModel extends Model
{
	use CallTrait, BookingHotelTrait, CoordinateTrait;

	protected $connection = 'mysql4';
	protected $table = 'booking_hotels';
	protected $appends = [
								'code', 'country', 'city', 'vendor',
								'built_data', 'image', 'description', 'star_rating'
							];

	protected $hidden = [
								'cc1', 'photo_url', 'city_hotel', 
								'distance', 'zip', 'countryDetail',
								'built_data', 'desc_en', 'class'
							];
	protected $searchColumnName = 'name';


	public function getCodeAttribute()
	{
		return $this->id;
	}	

	public function getVendorAttribute()
	{
		return 'b';
	}

	public function getCityAttribute()
	{
		return $this->city_hotel;
	}

	public function getAddressAttribute($value)
	{
		$value = $value.', '.$this->city.' - '.$this->zip.', '.$this->country;
		$value = str_replace([', ,', ' - ,'], [',', ','], $value);
		return $value;
	}

	public function getCountryAttribute()
	{
		return isset($this->countryDetail->country)
				 ? $this->countryDetail->country
				 : '';
	}

	public function getImageAttribute()
	{
		return $this->photo_url;
	}

	public function getDescriptionAttribute()
	{
		return $this->desc_en;
	}

	public function getStarRatingAttribute()
	{
		return $this->class;
	}


	public function getBuiltDataAttribute()
	{
		return collect([
					'id' => $this->id,
					'ukey' => $this->code.'_'.$this->vendor,
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


	

	public function countryDetail()
	{
		return $this->hasOne(
										'App\Models\CommonApp\CountryModel', 
										'country_code', 'cc1'
									);
	}


	public function hotelImages()
	{
		return $this->hasMany(
											'App\Models\HotelApp\BookingHotelImageModel', 
											'booking_hotel_id'
										);
	}


	public function images()
	{
		return $this->hotelImages->pluck('thumb_url')->toArray();
	}

}
