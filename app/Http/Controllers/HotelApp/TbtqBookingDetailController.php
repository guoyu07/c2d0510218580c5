<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\TbtqJsonBookingDetailModel;
use App\Traits\HotelApp\TbtqHotelTrait;
use App\Traits\CallTrait;

class TbtqBookingDetailController extends Controller
{
	use CallTrait, TbtqHotelTrait;

	public $url = 'http://api.tektravels.com/BookingEngineService_Hotel/HotelService.svc/rest/GetBookingDetail/';


	public function jsonModel()
	{
		return new TbtqJsonBookingDetailModel;
	}


	public function detail($request, $relationId)
	{
		$result = $this->jsonModel()
							->byRelationId($relationId)
								->first();

		if (!is_null($result) && $result->status) return $result;

		$json = $this->httpPost($this->url, $request);

		$result = is_null($result) ? $this->jsonModel() : $result;
		$result->tbtq_json_room_book_id = $relationId;
		$result->request = $request;
		$result->response = json_decode($json);
		$result->save();
		return $result;
	}

}
