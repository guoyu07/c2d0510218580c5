<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HotelApp\TbtqTokenController;
use App\Http\Controllers\HotelApp\TbtqHotelRoomController;
use App\Models\HotelApp\TbtqJsonHotelModel;
use App\Models\HotelApp\TbtqHotelModel;
use App\Traits\HotelApp\TbtqHotelTrait;
use App\Traits\CallTrait;


class TbtqHotelController extends Controller
{
	use CallTrait, TbtqHotelTrait;

	public $url = 'https://api.travelboutiqueonline.com/HotelAPI_V10/HotelService.svc/rest/GetHotelResult/';

	public $testUrl = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/GetHotelResult/';

	public $request;

	public function model()
	{
		return new TbtqHotelModel;
	}

	public function jsonModel()
	{
		return new TbtqJsonHotelModel;
	}


	public function hotels($request)
	{
		// $data = TbtqJsonHotelModel::find(16);
		// return $data;

		$auth = TbtqTokenController::call()->token();
		$result = new TbtqJsonHotelModel;

		if (!isset($auth->token)) return $result; 

		$request['TokenId'] = $auth->token;
		$request['EndUserIp'] = $auth->request->EndUserIp;

		$json = $this->httpPost($this->url, $request);
		$response = json_decode($json);
		$result->request = $request;
		$result->response = $response;
		if ($response == '') $result->errors = $json;
		$result->save();

		return $result;
	}



	public function hotel($request=[])
	{
		$auth = TbtqTokenController::call()->token();
		$result = null;

		if (isset($auth->TokenId)) {

			$RoomGuests = $this->roomGuests($request->RoomGuests);
			$NoOfRooms = count($RoomGuests);

			$params = [
					"TokenId" => $auth->token, // Got after Authenticate
					"EndUserIp" => $_SERVER['REMOTE_ADDR'],
					"CheckInDate" => $request->Dates->CheckInDate, // DD/MM/YYYY
					"NoOfNights" => $request->Nights, // 3
					"CountryCode" => $request->Destination->tbtq_countrycode, // SG
					"CityId" => $request->Destination->tbtq_destinationcode, // 14343
					"ResultCount" => 1000, // 1000
					"NoOfRooms" => $NoOfRooms, // = count(RoomGuests);
					"RoomGuests" => $RoomGuests,
					"PreferredHotel" => "", // name of hotel
					"MaxRating" => 5, // like 5
					"MinRating" => 3, // like 3
					"ReviewScore" => 0, // like 4
					"PreferredCurrency" => $request->PreferredCurrency, // INR
					"IsNearBySearchAllowed" => 0, // boolen 
					"GuestNationality" => "IN", // IN
					// "SortBy" => "",// like "Sort by Price, Star Rating"
					// "Order" => "",// int like "Ascending or Descending Order"
				];

			$result = $this->postHotel($params);
		}

		return $result;
	}


	public function hotelRoomsAndImages($id, Array $request)
	{
		$request = new Request($request);

		$model = $this->jsonModel()->find($id);
		$result = [];
		
		if (!is_null($model)) {
			$index = $request->index;
			$tboReq = $model->makeHotelRoomRequest($index);

			$rooms = TbtqHotelRoomController::call()
							->rooms($tboReq, $id, $index);

			$info = TbtqHotelInfoController::call()
								->info($tboReq, $id, $index);

			$rooms = $rooms->getTboInsertedData()
							->map(function ($item, $index) use ($info){
										$item['image'] = $info->images->random();
										return $item;
									});

			$result = ['rooms' => $rooms, 'images' => $info->images];
		}

		return $result;
	}



	/*
	| this function for if flight is booked
	| id stand for the table id 
	| index for the result column array index like flight index 
	*/
	public function book($id, $index)
	{
		$hotel = TbtqHotelModel::with('tbtqRooms')->find($id);
		$hotel->selected_index = $hotel->temp_selected_index; 
		$hotel->tbtqRooms->selected_index = $index;
		$hotel->tbtqRooms->save();
		$hotel->save();
		
		return $hotel;
	}


	

	/*
	| this function for pulling data from tbtq using method post 
	*/
	public function postHotel($params)
	{

		$json = null;
		$result = null;
		
		for ($i=0; $i <5; $i++) { 
			$json = $this->httpPost($this->url, $params);
			$result = json_decode($json);
			if (isset($result->HotelSearchResult->ResponseStatus)) {
				break;
			}
		}

		$tbtqHotelModel = new TbtqHotelModel;
		$tbtqHotelModel->request = $params;
		$tbtqHotelModel->result = $json;
		$tbtqHotelModel->save();

		if (!is_object($result)) {
			$result = (object)[];
		}

		// ====================pushing db detail in array====================
		$result->db = (object)[
				"id" => $tbtqHotelModel->id, 
				// "table" => "tbtq_hotels"
			];
		return $result;
	}




	/*
	|--------------------------------------------------------------------------
	| Checking or Fixing request field 
	|--------------------------------------------------------------------------
	*/
	public function roomGuests($array){
		$roomGuests = [];

		foreach ($array as $value) {
			$NoOfAdults = isset($value->no_of_adult) ? $value->no_of_adult : 0;

			$roomGuest = [
					'NoOfAdults' => $NoOfAdults, 
					'NoOfChild' => 0,
					'ChildAge' => []
				];

			if (isset($value->child_age) && !empty(isset($value->child_age))) {
				
				$roomGuest['NoOfChild'] = count($value->child_age);

				foreach ($value->child_age as $childAge) {
					$roomGuest['ChildAge'][] = $childAge->age;
				}
			}
			
			$roomGuests[] = $roomGuest;

		}
		
		return $roomGuests;
	}


	public function getRequestExample()
	{
		return [
				"EndUserIp" => '127.0.0.1',
				"TokenId" => 'XXXX-XXXXX-XXXXX-XXXX',
				"CheckInDate" => '14/07/2017',
				"NoOfNights" => '2',
				"CountryCode" => 'IN',
				"CityId" => 23232,
				"ResultCount" => 100,
				"PreferredCurrency" => 'INR',
				"GuestNationality" => "IN",
				"NoOfRooms" => 2,
				"RoomGuests" => [
												'NoOfAdults' => 2, 
												'NoOfChild' => 1, 
												"ChildAge" => [3]
											],
				"PreferredHotel" => '', // name of hotel
				"MaxRating" => 5, // star rating
				"MinRating" => 3, // star rating
				"ReviewScore" => 0,
				"IsNearBySearchAllowed" => 0,
				"SortBy" => "Price",// like "Sort by Price, Star Rating"
				"Order" => "Ascending",// int like "Ascending or Descending Order"
			];
	}



}
