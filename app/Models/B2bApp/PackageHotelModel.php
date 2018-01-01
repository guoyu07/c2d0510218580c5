<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\B2bApp\PackageHotelRoomModel;
use App\Http\Controllers\HotelApp\HotelsController;
use App\Traits\CallTrait;

class PackageHotelModel extends Model
{
	use CallTrait;

	protected $table = 'package_hotels';
	protected $appends = ['detail'];


	public function roomModel()
	{
		return new PackageHotelRoomModel;
	}


	public function packageRooms()
	{
		return $this->hasMany(
							'App\Models\B2bApp\PackageHotelRoomModel', 
							'package_hotel_id'
						);
	}


	public function hotelRooms()
	{
		return $this->packageRooms
									->pluck('room.roomtype')
										->toArray(); //added new line
	}


	public function selectedHotel()
	{
		$relatedData = collect([
						'a' => [
									'column' => 'hotel_id',
									'model' => 'App\Models\HotelApp\AgodaHotelModel'
								],
		
						'b' => [
									'column' => 'id',
									'model' => 'App\Models\HotelApp\BookingHotelModel'
								],
					]);

		$model = $relatedData->pull($this->vendor.'.model');
		$relatedCol = $relatedData->pull($this->vendor.'.column');
		
		return $this->belongsTo($model, 'hotel_code', $relatedCol);
	}



	public function hotelForView()
	{
		return HotelsController::call()
						->hotelByCode([
									'code' => $this->hotel_code, 
									'vendor' => $this->vendor
								]);
	}


	public function hotelDetail()
	{
		$hotelDetail = collect($this->selectedHotel->built_data);
		$result = (object)[
				"id" => $this->id,
				"code" => $hotelDetail->get('code'),
				"vendor" => $hotelDetail->get('vendor'),
				"name" => $hotelDetail->get('name'),
				"latitude" => $hotelDetail->get('latitude'),
				"longitude" => $hotelDetail->get('longitude'),
				"nights" => '',
				"location" => '',
				"endDate" => '',
				"startDate" => '',
				"address" => $hotelDetail->get('address'),
				"city" => $hotelDetail->get('city'),
				"country" => $hotelDetail->get('country'),
				"roomType" => $this->hotelRooms(),
				"image" => $hotelDetail->get('image'),
				"starRating" => $hotelDetail->get('star_rating'),
				"starRatingHtml" => '',
				"description" => $hotelDetail->get('description'),
				"shortDescription" => $hotelDetail->get('description'),
				"htmlDescription" => $hotelDetail->get('description'),
			];

		$result->starRatingHtml = starRating($result->starRating, 15, 15);
		$result->shortDescription = sub_string($result->description, 120);

		return $result;
	}


	public function images()
	{
		$images = $this->hotelForView()->first();
		return is_null($images) ? [] : $images->images();
	}


	public function imagesOld()
	{
		$images = [];
		$tempImg = [];

		if ($this->selected_hotel_vendor == 'tbtq') {
			$tempImg = $this->tbtqHotel
										->tbtqDetail->result
											->HotelInfoResult
												->HotelDetails->Images;

			$images = array_merge($images, $tempImg);
		}
		elseif ($this->selected_hotel_vendor == 'ss') {
			$tempImg = $this->skyscannerHotel->hotelDetail->images;
			$images = array_merge($images, $tempImg);
		}
		elseif ($this->selected_hotel_vendor == 'a') {
			$images = array_merge($images, $this->agodaHotelRoom->agodaHotel->images());
		}
		elseif ($this->selected_hotel_vendor == 'b') {
			$images = array_merge($images, $this->bookingHotelRoom->bookingHotel->images());
		}
		return $images;
	}

}
