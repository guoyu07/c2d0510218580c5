<?php

namespace App\Http\Controllers\TravelerApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TravelerApp\GuestDetailModel;
use App\Traits\TravelerApp\TbtqRequestTrait;
use App\Models\HotelApp\TbtqDestinationModel;
use App\Http\Controllers\HotelApp\TbtqTokenController;
use App\Http\Controllers\HotelApp\TbtqHotelController;
use App\Http\Controllers\TravelerApp\BookingController;
use App\Http\Controllers\HotelApp\TbtqVoucherController;
use App\Http\Controllers\HotelApp\TbtqRoomBookController;
use App\Http\Controllers\HotelApp\TbtqHotelRoomController;
use App\Http\Controllers\HotelApp\TbtqHotelInfoController;
use App\Http\Controllers\HotelApp\TbtqRoomBlockController;

class HotelsController extends Controller
{
	use TbtqRequestTrait;


	public function getHotels(Request $request)
	{
		$dest = TbtqDestinationModel::findOrFail($request->dest_code);

		// $req = $this->makeHotelRequest($request);
		
		// // it's model and has request and response
		// $data = TbtqHotelController::call()->hotels($req);

		return view('traveler.pages.hotel.search.index', ["dest" => $dest]);

	}


	public function getHotelDetail($id, $index)
	{
		$hotels = TbtqHotelController::call()
							->jsonModel()->findOrFail($id);

		$blade = [
				"id" => $id,
				"index" => $index,
				"detail" => $hotels->hotel($index),
			];

		return view('traveler.pages.hotel.detail.index', $blade);
	}


	public function getBlockRoom(Request $request, $id)
	{

		$this->validate($request, [
									"inx" => "required"
								]);

		$rooms = TbtqHotelRoomController::call()
						->jsonModel()->findOrFail($id);

		$req = $rooms->makeRoomBlockRequest($request->inx);

		abort_if(is_null($req), 403, 'request can\'t be null');

		$blockRoom = TbtqRoomBlockController::call()
								->blockRoom($req, $id);

		$blade = ["data" => $blockRoom];

		return view('traveler.pages.hotel.block.index', $blade);

	}


	public function getBookRoom(Request $request, $id)
	{
		$blockRoom = TbtqRoomBlockController::call()
								->jsonModel()->findOrFail($id);

		$this->storeGuestDetail($request, $id);

		$req = $blockRoom->makeRoomBookRequest();

		abort_if(is_null($req), 403, 'request can\'t be null');

		// $book is returning a model 
		$book = TbtqRoomBookController::call()->book($req, $id);

		// storing booked hotel in my booking
		$myBooking = BookingController::call()->store(
									new Request([
											"booked_to_id" => $book->id,
											"booked_to_type" => get_class($book)
										])
									);

		return redirect()->route('traveler.hotel.status', $myBooking->token);
	}



	public function getRoomStatus($token)
	{
		$booking = BookingController::call()->model()
							->byToken($token)->firstOrFail();

		return view('traveler.pages.hotel.book.index', [
							'data' => $booking->bookedTo,
							'redirect_to' => route('traveler.booking.detail', $booking->token)
						]);
	}


	public function storeGuestDetail(Request $request, $id)
	{

		$this->validate($request, [
			"guests" => "required",
			"guests.*.*.prefix" => "required",
			"guests.*.*.name" => "required",
			"guests.*.*.age" => "required"
		]);

		$user = auth()->guard('traveler')->user();
		$guestDetails = [];

		foreach ($request->guests as $key => $guests) {
			$lead = 1;
			
			foreach ($guests as $guest) {
				$guest = collect($guest);
				$name = collect(split_name($guest->get('name')));
				$data = [
						"tbtq_json_room_block_id" => intval($id),
						"which_room" => $key+1,
						"title" => $guest->get('prefix'),
						"firstname" => $name->get('firstname'),
						"lastname" => $name->get('lastname'),
						"phone" => $guest->get('phone'),
						"email" => $guest->get('email'),
						"lead_passenger" => $lead,
						"age" => $guest->get('age')
					];

				$guestDetails[] = $data;
				$lead = 0;
			}
		}

		// deleting privous data if any with same id
		GuestDetailModel::where('tbtq_json_room_block_id', $id)->delete();

		GuestDetailModel::insert($guestDetails);

		return $this;
	}

	public function getAgencyBalance()
	{
		dd(TbtqTokenController::call()->checkBalance());
	}


	public function getGenerateVoucher($id)
	{
		$bookedRoom = TbtqRoomBookController::call()
									->jsonModel()->findOrFail($id);

		$req = $bookedRoom->makeGenerateVoucherRequest();
		
		$voucher = TbtqVoucherController::call()->generate($req, $id);
		
		dd($voucher);
	}


}
