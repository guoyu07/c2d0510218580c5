<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\BookingHotelRoomModel;
use App\Http\Controllers\HotelApp\BookingHotelController;
use App\Http\Controllers\HotelApp\BookingScrapeController;
use App\Http\Controllers\HotelApp\BookingHotelImagesController;
use App\Http\Controllers\HotelApp\BookingHotelFacilitiesController;
use App\Traits\CallTrait;


class BookingHotelRoomsController extends Controller
{
	use CallTrait;

	public $url;
	public $path;
	public $rooms = [];
	public $images = [];
	public $facilities = [];
	public $bookingHotelId;

	public function model()
	{
		return new BookingHotelRoomModel;
	}


	public function rooms($bookingHotelId)
	{
		$this->bookingHotelId = (int) $bookingHotelId;
		$this->setRooms()->setImages();
		return [
						'rooms' => $this->roomsWithImage(), 
						'images' => $this->images,
					];
	}

	public function roomsWithImage()
	{
		$count = 0;
		$rooms = [];
		if (count($this->rooms)) {
			foreach ($this->rooms as $key => $room) {
				$rooms[] = [
						'id' => $room->id,
						'vendor' => 'b',
						'roomtype' => $room->roomtype,
					];
			}
		}
		return loopImages($rooms, $this->images);
	}


	public function setImages()
	{
		$this->images = BookingHotelImagesController::call()
										->images($this->bookingHotelId);
		return $this;
	}


	public function setRooms()
	{
		$this->rooms = $this->model()
									->findByHotelId($this->bookingHotelId);
		if (!count($this->rooms)) {
			$data = BookingScrapeController::call($this->bookingHotelId)
								->extractRoomTypes();
			if (count($data)) {
				$this->model()->insert($this->makeInsertArray($data));
				$this->rooms = $this->model()
											->findByHotelId($this->bookingHotelId);
			}
		}
		return $this;
	}


	public function makeInsertArray(Array $rooms)
	{
		$data = [];
		foreach ($rooms as $room) {
			$data[] = addDateColumns([
										"roomtype" => $room,
										"booking_hotel_id" => $this->bookingHotelId,
									]);
		}
		return $data;
	}

}
