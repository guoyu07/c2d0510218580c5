<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\TbtqJsonHotelInfoModel;
use App\Models\HotelApp\TbtqHotelDetailModel;
use App\Traits\TravelerApp\TbtqRequestTrait;
use App\Traits\HotelApp\TbtqHotelTrait;
use App\Traits\CallTrait;

class TbtqHotelInfoController extends Controller
{
	use CallTrait, TbtqHotelTrait, TbtqRequestTrait;

	public $url = 'https://api.travelboutiqueonline.com/HotelAPI_V10/HotelService.svc/rest/GetHotelInfo/';

	public $testUrl = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/GetHotelInfo/';
	

	public function model()
	{
		return new TbtqHotelDetailModel;
	}

	public function jsonModel()
	{
		return new TbtqJsonHotelInfoModel;
	}


	public function info($request, $relationId, $index)
	{
		// return $this->jsonModel()->find(36);

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
	| this function is for pulling rooms data from tbtq api 
	| using post method 
	*/
	public function postHotelDetail($params)
	{
		/* 
		| first finding from db that is alread had or not 
		| if not then it will return null
		*/
		$result = TbtqHotelDetailModel::call()->findByHotelCode($params['HotelCode']);

		if (is_null($result)) {


			$json =  $this->httpPost($this->url, $params);
			
			$status = 'inactive';

			$result = json_decode($json);
			
			if (is_null($result)) {
				$result = (object)[];
			}

			if (ifset($result->HotelInfoResult->ResponseStatus) == 1) {
				$status = 'active';
			}

			$tbtqHotelDetailModel = new TbtqHotelDetailModel;
			$tbtqHotelDetailModel->hotel_code = $params['HotelCode'];
			$tbtqHotelDetailModel->request = $params;
			$tbtqHotelDetailModel->result = $json;
			$tbtqHotelDetailModel->status = $status;
			$tbtqHotelDetailModel->save();

			

			// ====================pushing db detail in array====================
			$result->db = (object)[
					"id" => $tbtqHotelDetailModel->id, 
					// "table" => "tbtq_hotel_rooms"
				];
		}

		return $result;
	}


}
