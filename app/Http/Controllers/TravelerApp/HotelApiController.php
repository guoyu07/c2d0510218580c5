<?php

namespace App\Http\Controllers\TravelerApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HotelApp\TbtqHotelController;
use App\Http\Controllers\HotelApp\TbtqHotelRoomController;
use App\Http\Controllers\HotelApp\TbtqHotelInfoController;
use App\Traits\TravelerApp\TbtqRequestTrait;

class HotelApiController extends Controller
{
	use TbtqRequestTrait;

	public function hotels(Request $request)
	{
		$req = $this->makeHotelRequest($request);

		// it's model and has request and response
		$data = TbtqHotelController::call()->hotels($req);
		return json_encode([
								'id' => $data->id, 
								'hotels' => $data->hotels()
							]);
	}


	public function rooms($id, $index)
	{
		
		$hotels = TbtqHotelController::call()
							->jsonModel()->findOrFail($id);

		$req = $hotels->makeHotelRoomRequest($index);

		$data = TbtqHotelRoomController::call()
						->rooms($req, $id, $index);

		return json_encode(['rooms' => $data->rooms(), 'id' => $data->id]);

	}


	public function details($id, $index)
	{

		$hotels = TbtqHotelController::call()
							->jsonModel()->findOrFail($id);

		$req = $hotels->makeHotelInfoRequest($index);

		$data = TbtqHotelInfoController::call()
						->info($req, $id, $index);

		return json_encode(['details' => $data->details(), 'id' => $data->id]);
	}

}
