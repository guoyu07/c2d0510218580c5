<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonApp\GoogleMapController; 
use App\Models\Api\SkyscannerHotelDetailModel;
use App\Models\Api\SkyscannerHotelModel;
use App\Traits\CallTrait;


class SkyscannerHotelApiController extends Controller
{
	use CallTrait;

	private $apiKey = '';


	/*
	| this function is to get all hotels from api
	*/
	public function hotels($packageHotel)
	{
		$location = $packageHotel->route->geo_code;
		$result = null;

		$lat = isset($location->results[0]->geometry->location->lat) 
				 ? $location->results[0]->geometry->location->lat
				 : false;

		$lng = isset($location->results[0]->geometry->location->lng)
				 ? $location->results[0]->geometry->location->lng
				 : false;

		if ($lat && $lng) {
			$startDate = date_formatter($packageHotel->route->start_date, 'Y-m-d H:i:s');
			$endDate =  addDaysinDate($startDate, $packageHotel->route->nights);
				
			$guests = $this->guests($packageHotel->route->package->roomGuests);
			$params = (object)[
					"market" => "US",
					"currency" => "INR",
					"locale" => "en-US",
					"destination_latlng" => round($lat, 2).','.round($lng, 2),
					"check_in_date" => $startDate,
					"check_out_date" => $endDate,
					"guests" => $guests,
					"rooms" => $packageHotel->route->package->roomGuests->count()
				];
			
			$result = $this->getHotels($params);
		}

		return $result;
	}



	/*
	| this function is to get all hotels
	*/
	public function getHotels($params=[])
	{
		$url = "http://partners.api.skyscanner.net/apiservices/hotels/liveprices/v2/".$params->market."/".$params->currency."/".$params->locale."/".$params->destination_latlng."-latlong/".$params->check_in_date."/".$params->check_out_date."/".$params->guests."/".$params->rooms."?pageSize=50&imageLimit=13&apiKey=".$this->apiKey;
		
		$json = null;
		$result = null;
		
		for ($i=0; $i <5; $i++) { 
			$json = $this->httpGet($url);
			$result = json_decode($json);
			if (isset($result->hotels)) {
				break;
			}
		}

		$skyscannerHotel = new SkyscannerHotelModel;
		$skyscannerHotel->request = $params;
		$skyscannerHotel->result = $json;
		$skyscannerHotel->save();

		if (!is_object($result)) {
			$result = (object)[];
		}

		// ====================pushing db detail in array====================
		$result->db = (object)[
				"id" => $skyscannerHotel->id, 
				// "table" => "skyscanner_hotels"
			];
		return $result;
	}



	/*
	| this function is to get hotel detail from skyscanner api using get method
	*/
	public function hotelDetail($id, $index)
	{
		$skyscannerHotel = SkyscannerHotelModel::find($id);
		$hotelId = $skyscannerHotel->result->hotels[$index]->hotel_id;
		$url = "http://partners.api.skyscanner.net".$skyscannerHotel->result->urls->hotel_details."&hotelIds=".$hotelId;
		$result = $this->getHotelDetail($url);
		$skyscannerHotel->temp_selected_index = $index;
		$skyscannerHotel->skysacanner_temp_hotel_detail_id = $result->db->id;
		$skyscannerHotel->save();
		return $result;
	}


	/*
	| this function is to get hotel detail and rooms
	*/
	public function getHotelDetail($url)
	{
		$json = null;
		$result = null;
		
		for ($i=0; $i <5; $i++) { 
			$json = $this->httpGet($url);
			$result = json_decode($json);
			if (isset($result->hotels)) {
				break;
			}
		}


		$skyscannerHotelDetail = new SkyscannerHotelDetailModel;
		$skyscannerHotelDetail->request = $url;
		$skyscannerHotelDetail->result = $json;
		$skyscannerHotelDetail->save();

		if (!is_object($result)) {
			$result = (object)[];
		}

		// ====================pushing db detail in array====================
		$result->db = (object)[
				"id" => $skyscannerHotelDetail->id, 
				// "table" => "skyscanner_hotel_details"
			];

		return $result;

	}


	/*
	| this function is to save index of the booked hotel
	*/	
	public function book($id, Request $request)
	{
		$skyscannerHotel = SkyscannerHotelModel::find($id);
		$skyscannerHotel->selected_index = $skyscannerHotel->temp_selected_index;
		$skyscannerHotel->skysacanner_hotel_detail_id = $skyscannerHotel
																										->skysacanner_temp_hotel_detail_id;
		$skyscannerHotel->hotelDetailTemp->agent_prices_index = $request->apk;
		$skyscannerHotel->hotelDetailTemp->room_offers_index = $request->rok;
		$skyscannerHotel->hotelDetailTemp->room_index = $request->rk;

		$skyscannerHotel->hotelDetailTemp->save();
		$skyscannerHotel->save();

		return $skyscannerHotel;
	}


	/*
	| this function is to get total number of guests
	*/
	public function guests($rooms)
	{
		$guests = 0;

		foreach ($rooms as $room) {
			$guests += $room->no_of_adult;
			$guests += $room->childAge->count();
		}

		return $guests;
	}


	/*
	| this function is to make http request using get request
	*/
	public function httpGet($url){
		$ch = curl_init();  

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"GET");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

		curl_setopt($ch, CURLOPT_HTTPHEADER,[
				'Content-Type: application/x-www-form-urlencoded', 
				'Accept: application/json'
			]);

		$output = curl_exec($ch);

		curl_close($ch);
		return $output;
	}


	public function __construct()
	{
		$this->apiKey = env('SKYSCANNER_API_KEY');
	}


}
