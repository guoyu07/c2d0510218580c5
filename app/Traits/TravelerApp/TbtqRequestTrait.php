<?php 

namespace App\Traits\TravelerApp;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\HotelApp\TbtqDestinationModel;

trait TbtqRequestTrait 
{

	// this function 
	public function makeHotelRequest(Request $request)
	{
		$start = Carbon::createFromFormat('d/m/Y', $request->start);
		$end = Carbon::createFromFormat('d/m/Y', $request->end);

		$dest = TbtqDestinationModel::findOrFail($request->dest_code);

		$maxRating = isset($request->max_rating) 
							 ? $request->max_rating 
							 : 5;
		$minRating = isset($request->min_rating) 
							 ? $request->min_rating 
							 : 3;

		return [
				"EndUserIp" => $_SERVER['REMOTE_ADDR'],
				"TokenId" => 'XXXX-XXXXX-XXXXX-XXXX', // must set in tbtq
				"CheckInDate" => $request->start,
				"NoOfNights" => $end->diffInDays($start),
				"CountryCode" => $dest->country_code,
				"CityId" => (int) $dest->destination_code,
				"ResultCount" => 10,
				"PreferredCurrency" => 'INR',
				"GuestNationality" => "IN",
				"NoOfRooms" => count($request->rooms),
				"RoomGuests" => $this->getRoomGuests($request->rooms),
				"PreferredHotel" => '', // name of hotel
				"MaxRating" => $maxRating, // star rating
				"MinRating" => $minRating, // star rating
				"ReviewScore" => 0,
				"IsNearBySearchAllowed" => 0,
				// "SortBy" => "Price",// like "Sort by Price, Star Rating"
				// "Order" => "Ascending",// int like "Ascending or Descending Order"
			];
	}


	public function getRoomGuests($data)
	{
		$guests = [];
		foreach ($data as $key => $value) {
			$guest = [
					'NoOfAdults' => 2, 
					'NoOfChild' => 0, 
					"ChildAge" => []
				];

			if (isset($value['adult'])) {
				$guest['NoOfAdults'] = (int) $value['adult'];
			}

			if (isset($value['kids_age'])) {
				$guest['NoOfChild'] = count($value['kids_age']);
				$guest['ChildAge'] = array_map('intval', $value['kids_age']);
			}

			$guests[] = $guest;
		}
		return $guests;
	}

}
