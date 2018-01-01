<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\BookingHotelImageModel;
use App\Traits\CallTrait;

class BookingHotelImagesController extends Controller
{
	use CallTrait;

	public $bookingHotelId;

	public function model()
	{
		return new BookingHotelImageModel;
	}

	/*public function bulkInsert(Array $array)
	{
		return BookingHotelImageModel::insert($array);
	}*/


	public function images($hotelId)
	{
		$this->bookingHotelId = (int) $hotelId;
		$images = $this->model()->images($this->bookingHotelId);
		if (!count($images)) {
			$data = (array) BookingScrapeController::call($this->bookingHotelId)
								->extractImages();
			$this->model()->insert($this->makeInsertArray($data));
			$images = $this->model()->images($this->bookingHotelId);
		}

		if (!count($images)) {
			$images[] = urlDefaultImageRoom();
		}

		return $images;
	}


	public function makeInsertArray(Array $images)
	{
		$data = [];
		foreach ($images as $image) {
			$data[] = addDateColumns([
										"bimgid" => $image->id,
										"booking_hotel_id" => $this->bookingHotelId,
										"thumb_url" => $image->thumb_url,
										"large_url" => $image->large_url,
									]);
		}
		return $data;
	}



}
