<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\TbtqHotelRoomModel;
use App\Models\HotelApp\TbtqJsonHotelRoomModel;
use App\Traits\HotelApp\TbtqHotelTrait;
use App\Traits\CallTrait;

class TbtqHotelRoomController extends Controller
{
	use CallTrait, TbtqHotelTrait;

	public $url = 'https://api.travelboutiqueonline.com/HotelAPI_V10/HotelService.svc/rest/GetHotelRoom/';

	public $testUrl = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/GetHotelRoom/';
	
	public $request;

	public function model()
	{
		return new TbtqHotelRoomModel;
	}

	public function jsonModel()
	{
		return new TbtqJsonHotelRoomModel;
	}

	public function rooms($request, $relationId, $index)
	{
		// return $this->jsonModel()->find(43);
		
		$json = $this->httpPost($this->url, $request);
		$result = $this->jsonModel();
		$result->tbtq_json_hotel_id = $relationId;
		$result->index = $index;
		$result->request = $request;
		$result->response = json_decode($json);
		$result->save();
		return $result;
	}

	/*
	| this function is making request array and getting data
	*/
	public function hotelRoom($id, $index)
	{
		$tbtqHotelModel = TbtqHotelModel::find($id);
		$hotels = $tbtqHotelModel->result;
		$request = $tbtqHotelModel->request; 
		$result = (object)['rooms' => null, 'detail' => null];

		if (!is_null($hotels) && !is_null($request)) {

			$params = [
					"ResultIndex" =>$hotels->HotelSearchResult->HotelResults[$index]->ResultIndex,
					"HotelCode" => $hotels->HotelSearchResult->HotelResults[$index]->HotelCode,
					"EndUserIp" =>$request->EndUserIp,
					"TokenId" =>$request->TokenId,
					"TraceId" =>$hotels->HotelSearchResult->TraceId
				];
			$result->rooms = $this->postHotelRoom($params);	
			$result->detail = $this->postHotelDetail($params);	
			
			// updating some colums here
			$tbtqHotelModel->temp_selected_index = $index;
			$tbtqHotelModel->tbtq_hotel_room_id = $result->rooms->db->id;
			$tbtqHotelModel->tbtq_hotel_detail_id = $result->detail->db->id;
			$tbtqHotelModel->save();
		}
		return $result;
	}


	/*
	| this function is for pulling rooms data from tbtq api 
	| using post method 
	*/
	public function postHotelRoom($params)
	{
		$result =  $this->httpPost($this->url, $params);

		$tbtqHotelRoomModel = new TbtqHotelRoomModel;
		$tbtqHotelRoomModel->request = $params;
		$tbtqHotelRoomModel->result = $result;
		$tbtqHotelRoomModel->save();

		$result = json_decode($result);
		if (!$result) {
			$result = (object)[];
		}

		// ====================pushing db detail in array====================
		$result->db = (object)[
				"id" => $tbtqHotelRoomModel->id, 
				// "table" => "tbtq_hotel_rooms"	
			];
		return $result;

	}






}
