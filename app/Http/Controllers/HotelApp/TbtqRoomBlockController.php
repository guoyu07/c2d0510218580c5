<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\TbtqJsonRoomBlockModel;
use App\Traits\HotelApp\TbtqHotelTrait;
use App\Traits\CallTrait;


class TbtqRoomBlockController extends Controller
{
	use CallTrait, TbtqHotelTrait;

	public $url = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/BlockRoom/';


	public function jsonModel()
	{
		return new TbtqJsonRoomBlockModel;
	}


	public function blockRoom($request, $relationId)
	{
		// return $this->jsonModel()->find(10);
		$json = $this->httpPost($this->url, $request);
		$result = $this->jsonModel();
		$result->tbtq_json_hotel_room_id = $relationId;
		$result->request = $request;
		$result->response = json_decode($json);
		$result->save();
		return $result;
	}

}