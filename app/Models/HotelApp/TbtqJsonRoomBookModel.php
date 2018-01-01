<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\HotelApp\TbtqTokenController;
use App\Http\Controllers\HotelApp\TbtqVoucherController;
use App\Http\Controllers\HotelApp\TbtqBookingDetailController;
use App\Http\Controllers\HotelApp\TbtqCancelBookingController;


class TbtqJsonRoomBookModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'tbtq_json_room_books';
	protected $casts = ['request' => 'object', 'response' => 'object'];
	protected $appends = [
				'status', 'hotel_name', 'is_booked', 'is_canceled',
				'lead_passenger', 'booked_rooms', 'total_amount', 
				'passengers'
			];
			


	public function getStatusAttribute()
	{
		return isset($this->response->BookResult->ResponseStatus)
				 ? $this->response->BookResult->ResponseStatus
				 : 0;
	}


	public function getHotelNameAttribute()
	{
		return $this->status == 1 ? $this->request->HotelName : null;
	}



	public function getIsBookedAttribute()
	{
		return $this->status && 
						$this->response->BookResult
									->HotelBookingStatus == 'Confirmed'
						 ? true 
						 : false;
	}


	public function getIsCanceledAttribute()
	{
		return isset($this->canceledBooking->get_change_status)
				 ? $this->canceledBooking->get_change_status
				 : 0;
	}


	public function getLeadPassengerAttribute()
	{
		$guest = $this->roomBlock->guestDetails()
										->byLeadPassenger()->first();

		if (is_null($guest)) return null;

		return $guest;
	}


	public function getPassengersAttribute()
	{
		return $this->roomBlock->guestByRooms();
	}


	public function getBookedRoomsAttribute()
	{
		if (!$this->status) return [];

		$rooms = [];

		foreach ($this->request->HotelRoomsDetails as $room) {
			$rooms[] = (object) [
											"room_type" => $room->RoomTypeName,
											"price" => $room->Price->PublishedPriceRoundedOff
										];
		}

		return $rooms;
	}


	public function getTotalAmountAttribute()
	{
		if (!$this->is_booked) return null;
		return array_sum(array_column(array_column($this->request->HotelRoomsDetails, 'Price'), 'PublishedPriceRoundedOff'));
	}



	public function roomBlock()
	{
		return $this->belongsTo(
										'App\Models\HotelApp\TbtqJsonRoomBlockModel',
										'tbtq_json_room_block_id'
									);
	}



	public function makeGenerateVoucherRequest()
	{
		$tokenId = TbtqTokenController::call()->token();

		return !$this->is_booked ? null : [
						"EndUserIp" => $this->request->EndUserIp,
						"TokenId" => $tokenId->token,
						"BookingId" => $this->response->BookResult->BookingId
					];
	}


	public function makeBookingDetailRequest()
	{
		return $this->makeGenerateVoucherRequest();
	}


	public function makeSendChangeRequest($remarks = '')
	{
		$req = $this->makeGenerateVoucherRequest();
		if (is_null($req)) return null;

		return array_merge($req, [
								"RequestType" => 4, 
								"Remarks" => $remarks
							]);

	}


	public function generateVoucher()
	{
		return TbtqVoucherController::call()
						->generate($this->makeGenerateVoucherRequest(), $this->id);
	}


	public function getBookingDetail()
	{
		return TbtqBookingDetailController::call()
						->detail($this->makeBookingDetailRequest(), $this->id);
	}


	public function canceledBooking()
	{
		return $this->hasOne(
											'App\Models\HotelApp\TbtqJsonCancelBookingModel', 
											'tbtq_json_room_book_id'
										);
	}


	public function cancelBooking($remarks = '')
	{
		$cancel = new TbtqCancelBookingController;
		$send = $cancel->sendChange(
								$this->makeSendChangeRequest($remarks), $this->id);
		return $cancel->getChange($send->makeGetChangeRequest(), $this->id);
	}


	public function pullDetailsIfBooked()
	{
		if ($this->is_booked) {
			$this->generateVoucher();
			$this->getBookingDetail();
		}
	}



}

