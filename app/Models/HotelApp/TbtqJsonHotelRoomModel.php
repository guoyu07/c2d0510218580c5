<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\HotelApp\TboHotelRoomModel;
use App\Traits\Models\ModelTrait;

class TbtqJsonHotelRoomModel extends Model
{
	use ModelTrait;

	protected $connection = 'mysql4';
	protected $table = 'tbtq_json_hotel_rooms';
	protected $appends = ['status', 'roomtypes'];
	protected $casts = ['request' => 'object', 'response' => 'object'];

	public $with = ['hotels'];

	public function getStatusAttribute()
	{
		return isset($this->response->GetHotelRoomResult->ResponseStatus)
				 ? $this->response->GetHotelRoomResult->ResponseStatus
				 : 0;
	}



	public function getRoomtypesAttribute()
	{
		$this->casts['response'] = 'array';

		$response = collect(array_get(
						$this->response, 'GetHotelRoomResult.HotelRoomsDetails'
					));

		$this->casts['response'] = 'object';

		return $response->pluck('RoomTypeName')->unique()
							->map(function($item, $key){
										return [
											'id' => $key,
											'vendor' => 'tbo',
											'roomtype' => $item,
											'property_type' => $item,
											'vendor_id' => $this->id,
										];
									});
	}


	public function getTboInsertedData()
	{
		$result = $this->insertedRooms->pluck('built_data')
										->unique('roomtype')->values();

		if (!$result->count()) {
			$this->casts['response'] = 'array';

			$response = collect(array_get(
							$this->response, 'GetHotelRoomResult.HotelRoomsDetails'
						));

			$this->casts['response'] = 'object';
			if (isset($this->request->HotelCode)) {
				$data = $response->pluck('RoomTypeName')->unique()
								->map(function($item, $key){
											return [
													'tbo_hotel_id' => $this->tbtq_json_hotel_id,
													'hotel_code' => $this->request->HotelCode,
													'roomtype' => $item,
												];
										})
									->values()->toArray();

				// inserting data to another table
				TboHotelRoomModel::insert($data);

				$inserted = TboHotelRoomModel::byHotelCode(
												$this->request->HotelCode
											)->get()->unique('roomtype');

				$result = $inserted->pluck('built_data');
			}
		}

		return $result;
	}


	public function insertedRooms()
	{
		return $this->hasMany(
							TboHotelRoomModel::class, 'tbo_hotel_id', 'tbtq_json_hotel_id'
						);
	}


	public function rooms()
	{
		if ($this->status != 1) return [];

		$rooms = [];

		foreach ($this->response->GetHotelRoomResult->HotelRoomsDetails as $key => $room) {

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


	public function roomsOld()
	{
		$rooms = [];
		if ($this->status == 1) {
			foreach ($this->response->GetHotelRoomResult->RoomCombinations->RoomCombination as $combinationKey => $combination) {
				$roomComb = (object)[
								'id' => $combinationKey,
								'room_type' => '',
								'price' => 0,
								'inclusion' => [],
								'cancellation_policy' => '',
							];

				foreach ($combination->RoomIndex as $roomIndex) {

					$room = $this->getRoomByRoomIndex($roomIndex);

					$roomComb->room_type .= $room->RoomTypeName;
					$roomComb->price += $room->Price->PublishedPriceRoundedOff;
					$roomComb->inclusion = array_merge(
																			$roomComb->inclusion, 
																			$room->Inclusion
																		);
					if ($roomComb->cancellation_policy != $room->CancellationPolicy) {
						$roomComb->cancellation_policy 
												.= $room->CancellationPolicy;
					}
				}

				$rooms[] = $roomComb;
			}
		}

		return $rooms;
	}


	public function hotels()
	{
		return $this->belongsTo(
					'App\Models\HotelApp\TbtqJsonHotelModel',
					'tbtq_json_hotel_id'
				);
	}


	public function hotel()
	{
		$hotel = null;
		
		if (!is_null($this->hotels)) {
			$hotel = $this->hotels->hotelFromResponse($this->index);
		}

		return $hotel;
	}



	public function selectedRooms($combIndex)
	{
		$rooms = [];

		if (isset($this->response->GetHotelRoomResult->RoomCombinations->RoomCombination[$combIndex])) {
			$combination = $this->response
										->GetHotelRoomResult
											->RoomCombinations
												->RoomCombination[$combIndex];
			foreach ($combination->RoomIndex as $roomIndex) {
				$rooms[] = $this->getRoomByRoomIndex($roomIndex);
			}
		}

		return $rooms;	
	}


	public function getRoomByRoomIndex($roomIndex)
	{
		$index = array_search($roomIndex, 
							array_column($this->response
								->GetHotelRoomResult
									->HotelRoomsDetails, 'RoomIndex'));

		return $this->response->GetHotelRoomResult
									->HotelRoomsDetails[$index];

	}


	public function makeRoomBlockRequest(Array $indexes)
	{
		if (!is_int_array($indexes)) return null;

		$req = null;

		$hotel = $this->hotel();
		$hotelRequest = $this->hotels->request;

		if (!is_null($hotel) && !is_null($hotelRequest)) {
			
			$req = [
					"ResultIndex" => $hotel->ResultIndex,
					"HotelCode" => $hotel->HotelCode,
					"HotelName" => $hotel->HotelName,
					"GuestNationality" => $hotelRequest->GuestNationality,
					"NoOfRooms" => $hotelRequest->NoOfRooms,
					"ClientReferenceNo" => "0",
					"IsVoucherBooking" => "true",
					"EndUserIp" => $hotelRequest->EndUserIp,
					"TokenId" => $hotelRequest->TokenId,
					"TraceId" => $this->request->TraceId,
					"HotelRoomsDetails" => []
				];

			foreach ($indexes as $index) {

				$room = $this->response->GetHotelRoomResult
												->HotelRoomsDetails[$index];

				/*$bedTypeCode = isset($room->BedTypes->BedTypeCode)
										 ? $room->BedTypes->BedTypeCode
										 : null;*/

				$req['HotelRoomsDetails'][] = [
									"RoomIndex" 	 => $room->RoomIndex,
									"RoomTypeCode" => $room->RoomTypeCode,
									"RoomTypeName" => $room->RoomTypeName,
									"RatePlanCode" => $room->RatePlanCode,
									"BedTypeCode"	 => null,
									"Supplements"  => null,
									"SmokingPreference" => 0,
									"Price" => (array) $room->Price,
							];

			}
		}

		return $req;
	}


}
