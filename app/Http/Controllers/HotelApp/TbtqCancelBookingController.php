<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\TbtqJsonCancelBookingModel;
use App\Traits\HotelApp\TbtqHotelTrait;
use App\Traits\CallTrait;

class TbtqCancelBookingController extends Controller
{
	use CallTrait, TbtqHotelTrait;

	public $sendUrl = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/SendChangeRequest/';

	public $getUrl = 'http://api.tektravels.com/BookingEngineService_Air/AirService.svc/rest/GetChangeRequestStatus/';


	public function jsonModel()
	{
		return new TbtqJsonCancelBookingModel;
	}


	public function sendChange($request, $relationId)
	{
		$result = $this->jsonModel()
							->byRelationId($relationId)
								->first();

		if (!is_null($result) && $result->send_change_status) return $result;

		$json = $this->httpPost($this->sendUrl, $request);
		$result = is_null($result) ? $this->jsonModel() : $result;
		$result->tbtq_json_room_book_id = $relationId;
		$result->send_change_request = $request;
		$result->send_change_response = json_decode($json);
		$result->save();
		return $result;
	}


	public function getChange($request, $relationId)
	{
		$result = $this->jsonModel()
							->byRelationId($relationId)
								->first();

		if (!is_null($result) && $result->get_change_status) return $result;

		$json = $this->httpPost($this->getUrl, $request);

		$result = is_null($result) ? $this->jsonModel() : $result;
		$result->tbtq_json_room_book_id = $relationId;
		$result->get_change_request = $request;
		$result->get_change_response = json_decode($json);
		$result->save();
		return $result;
	}


}
