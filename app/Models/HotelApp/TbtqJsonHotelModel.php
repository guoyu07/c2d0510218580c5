<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TbtqJsonHotelModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'tbtq_json_hotels';
	protected $casts = ['request' => 'object', 'response' => 'object'];
	protected $appends = [
			'trace_id', 'hotels', 'hotel_count', 'city_id', 'vendor',
			'start_date', 'end_date', 'nights', 'is_date_passed',

		];


	public function setTokenAttribute()
	{
		if (!strlen($this->token)) {
			$this->attributes['token'] = new_token();
		}
	}


	public function getVendorAttribute()
	{
		return 'tbo';
	}


	public function getTokenIdAttribute()
	{
		return isset($this->request->TokenId)
				 ? $this->request->TokenId
				 : null;
	}

	public function getTraceIdAttribute()
	{
		return isset($this->response->HotelSearchResult->TraceId)
				 ? $this->response->HotelSearchResult->TraceId
				 : null;
	}


	public function getStartDateAttribute()
	{
		return Carbon::createFromFormat('d/m/Y', $this->request->CheckInDate);
	}

	public function getEndDateAttribute()
	{
		return $this->start_date->addDays($this->nights);
	}


	public function getNightsAttribute()
	{
		return isset($this->request->NoOfNights)
				 ? $this->request->NoOfNights
				 : null;
	}


	public function getCityIdAttribute()
	{
		return isset($this->request->CityId)
				 ? $this->request->CityId
				 : null;
	}

	public function getHotelCountAttribute()
	{
		return isset($this->response->HotelSearchResult->HotelResults)
				 ? count($this->response->HotelSearchResult->HotelResults)
				 : 0;
	}


	public function getHotelsAttribute()
	{
		if (is_null($this->hotels)) {
			return $this->hotels();
		}
	}


	public function getIsDatePassedAttribute()
	{
		return $this->start_date->lt(Carbon::now());
	}


	public function destination()
	{
		return $this->hasOne(
				'App\Models\HotelApp\TbtqDestinationModel', 
				'destination_code', 'city_id'
			);
	}


	public function hotels()
	{
		$hotels = [];

		for ($i=0; $i < $this->hotel_count ; $i++) { 
			$hotels[] = $this->hotel($i);
		}

		return $hotels;
	}


	public function hotel($index)
	{
		$hotel = null;

		if (isset($this->response->HotelSearchResult->HotelResults[$index])) {

			$data = $this->response
							->HotelSearchResult
							 ->HotelResults[$index];

			$hotel = (object) [
					'vendor' => 'tbtq',
					'id' => $data->HotelCode,
					'name' => $data->HotelName,
					'latitude' => $data->Latitude,
					'image' => $data->HotelPicture,
					'longitude' => $data->Longitude,
					'address' => $data->HotelAddress,
					'star_rating' => $data->StarRating,
					'description' => $data->HotelDescription, 
					'price' => $data->Price->PublishedPriceRoundedOff,
				];
		}

		return $hotel;
	}


	public function getBuiltDataAttribute()
	{
		$hotels = [];
		if (isset($this->response->HotelSearchResult->HotelResults)) {
			foreach ($this->response->HotelSearchResult->HotelResults as $key => $value) {
				$value = rejson_decode($value, true);
				$hotels[] = $this->builtHotelData($key, $value);
			}
		}
		return collect($hotels);
	}


	public function builtDataByIndex($index)
	{
		return $this->builtHotelData(
							$index, $this->hotelFromResponse($index)
						);
	}


	public function builtHotelData($index, Array $hotel = [])
	{
		if (empty($hotel)) return collect();
		
		$hotel = collect($hotel);
		$code = $hotel->get('HotelCode');

		$data = [
					'id' => $this->id,
					'ukey' => str_replace('|', '_', $code).'_'.$this->vendor,
					'code' => $code,
					'index' => $index,
					'name' => $hotel->get('HotelName'),
					'city' => $this->destination->destination,
					'image' => $hotel->get('HotelPicture'),
					'images' => [$hotel->get('HotelPicture')],
					'vendor' => $this->vendor,
					'address' => $hotel->get('HotelAddress'),
					'country' => $this->destination->country,
					'latitude' => $hotel->get('Latitude'),
					'longitude' => $hotel->get('Longitude'),
					'description' => $hotel->get('HotelDescription'),
					'star_rating' => $hotel->get('StarRating'),
				];

		return collect($data);
	}


	public function hotelFromResponse($index)
	{
		return array_get(
								rejson_decode($this->response, true), 
								'HotelSearchResult.HotelResults.'.$index,
								[]
							);
	}



	public function makeHotelRoomRequest($index)
	{
		$hotel = $this->hotelFromResponse($index);
		return is_null($hotel) ? null : [
				"ResultIndex" => array_get($hotel, 'ResultIndex'),
				"HotelCode" => array_get($hotel, 'HotelCode'),
				"EndUserIp" => env('GATEWAY_IP'),
				"TokenId" => $this->TokenId,
				"TraceId" => $this->TraceId
			];
	}


	public function makeHotelInfoRequest($index)
	{
		return $this->makeHotelRoomRequest($index);
	}


	public function __construct(array $attributes = [])
	{
		$this->setTokenAttribute();
		parent::__construct($attributes);
	}

}
