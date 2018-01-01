<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\TbtqJsonRoomBookModel;
use App\Traits\HotelApp\TbtqHotelTrait;
use App\Traits\CallTrait;

class TbtqRoomBookController extends Controller
{
	use CallTrait, TbtqHotelTrait;

	public $url = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/Book/';


	public function jsonModel()
	{
		return new TbtqJsonRoomBookModel;
	}


	public function book($request, $relationId)
	{
		// return $this->jsonModel()->find(4);
		$json = $this->httpPost($this->url, $request);
		$result = $this->jsonModel();
		$result->tbtq_json_room_block_id = $relationId;
		$result->request = $request;
		$result->response = json_decode($json);
		$result->save();

		// pulling details if booked
		$result->pullDetailsIfBooked(); 
		
		return $result;
	}





}
