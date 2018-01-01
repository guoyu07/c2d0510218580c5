<?php

namespace App\Http\Controllers\TravelerApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TravelerApp\MyBookingModel;
use App\Traits\CallTrait;

class BookingController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new MyBookingModel;
	}


	public function history()
	{
		return view('traveler.pages.booking.history');
	}


	public function store(Request $request)
	{
		$request->validate([
									"booked_to_id" => "required|integer",
									"booked_to_type" => "required|string"
								]);

		$myBooking = $this->model();
		$myBooking->booked_to_id = $request->booked_to_id;
		$myBooking->booked_to_type = $request->booked_to_type;
		$myBooking->save();
		return $myBooking;
	}


	public function detail($token)
	{
		$booking = $this->model()->byToken($token)->firstOrFail();

		return view('traveler.pages.booking.detail', [
							'data' => $booking
						]);
	}


	public function getVoucher($token)
	{
		$booking = $this->model()->byToken($token)->firstOrFail();
		dd($booking->bookedTo->bookingDetail()->response);
	}


	public function getCancelBooking($token)
	{
		$booking = $this->model()->byToken($token)->firstOrFail();

		$cancelRes = $booking->bookedTo->canceledBooking;
		
		abort_if(is_null($cancelRes), 404);
		// dd($data->get_change_message);

		return view('traveler.pages.booking.cancel', [
							'data' => $booking,
							'cancelRes' => $cancelRes
						]);
	}


	public function postCancelBooking(Request $request, $token)
	{
		$request->validate(['remarks' => 'required|min:15|string']);

		$booking = $this->model()->byToken($token)->firstOrFail();

		$data = $booking->bookedTo->cancelBooking($request->remarks);

		return redirect()->route('traveler.booking.cancel', $token);
	}


}
