<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;

class TbtqJsonRoomBlockModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'tbtq_json_room_blocks';
	protected $appends = [
							'status', 'room_indexes', 'total_amount', 'hotel_name'
						];
	protected $casts = ['request' => 'object', 'response' => 'object'];


	public function getRoomIndexesAttribute()
	{
		if ($this->status != 1) return [];

		return array_column($this->response->BlockRoomResult->HotelRoomsDetails, 'RoomIndex');
	}


	public function getStatusAttribute()
	{
		return isset($this->response->BlockRoomResult->ResponseStatus)
				 ? $this->response->BlockRoomResult->ResponseStatus
				 : 0;
	}

	public function getTotalAmountAttribute()
	{
		if ($this->status != 1) return null;
		return array_sum(array_column(array_column($this->response->BlockRoomResult->HotelRoomsDetails, 'Price'), 'PublishedPriceRoundedOff'));
	}


	public function getHotelNameAttribute()
	{
		return isset($this->request->HotelName)
				 ? $this->request->HotelName
				 : null;
	}


	public function roomData()
	{
		if ($this->status != 1) return [];

		$rooms = [];

		foreach ($this->response->BlockRoomResult->HotelRoomsDetails as $key => $room) {

			$rooms[] = (object) [
								'id' => $key,
								'room_type' => $room->RoomTypeName,
								'price' => $room->Price->PublishedPriceRoundedOff,
								'inclusion' => $room->Inclusion,
								'cancellation_policy' => $room->CancellationPolicy,
								'sequence' => $room->SequenceNo,
								'source' => $room->InfoSource
							];
		}

		return $rooms;
	}


	public function rooms()
	{
		return $this->belongsTo(
					'App\Models\HotelApp\TbtqJsonHotelRoomModel',
					'tbtq_json_hotel_room_id'
				);
	}

	public function guestDetails()
	{
		return $this->hasMany(
					'App\Models\TravelerApp\GuestDetailModel', 
					'tbtq_json_room_block_id'
				);
	}


	public function guestByRooms()
	{
		return $this->guestDetails->groupBy('which_room')->values();
	}


	public function makeRoomBookRequest()
	{
		if ($this->status != 1) return null;

		$req = (array) $this->request;
		$req['HotelRoomsDetails'] = [];
		foreach ($this->response->BlockRoomResult->HotelRoomsDetails as $key => $room) {
			/*$bedTypeCode = isset($room->BedTypes->BedTypeCode)
									 ? $room->BedTypes->BedTypeCode
									 : null;*/

			$roomsDetail = [
								"RoomIndex" => $room->RoomIndex,
								"RoomTypeCode" => $room->RoomTypeCode,
								"RoomTypeName" => $room->RoomTypeName,
								"RatePlanCode" => $room->RatePlanCode,
								"BedTypeCode" => null,
								"SmokingPreference" => 0,
								"Supplements" => null,
								"Price" => (array) $room->Price,
								"HotelPassenger" => []
						];

			$guests = $this->guestDetails()->byWhichRoom($key+1)->get();

			foreach ($guests as $guest) {
				$roomsDetail["HotelPassenger"][] = $guest->forTbtq();
			}

			$req['HotelRoomsDetails'][] = $roomsDetail;
		}

		return $req;
	}




}
