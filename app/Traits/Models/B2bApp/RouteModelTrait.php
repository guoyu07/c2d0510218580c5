<?php 

namespace App\Traits\Models\B2bApp;
use Carbon\Carbon;

trait RouteModelTrait 
{


	public function makeHotelParams($request)
	{
		$maxRating = isset($request->max_rating) 
							 ? $request->max_rating
							 : 5;
		$minRating = isset($request->min_rating) 
							 ? $request->min_rating
							 : 0;

		return [
				"adults" => 2,
				"location" => '',
				"skip" => $request->skip,
				"name" => $request->name,
				"take" => $request->take,
				'max_rating' => $maxRating,
				'min_rating' => $minRating,
				'latitude' => $this->destination_detail->latitude, 
				'longitude' => $this->destination_detail->longitude, 
				"checkOutDate" => $this->end_datetime->format('Y-m-d'),
				"checkInDate" => $this->start_datetime->format('Y-m-d'),
			];
	}

	public function makeCruiseParams($request)
	{
		$request = $request->all();
		$take = array_get($request, 'take', 20);
		if ($take > 50) { $take = 50; }

		return [
				"skip" => array_get($request, 'skip', 0),
				"name" => array_get($request, 'name', ''),
				"take" => $take,
				'latitude' => $this->destination_detail->latitude, 
				'longitude' => $this->destination_detail->longitude, 
			];
	}

	/*
	| this function is to fix date 
	| like every date is invalid when making package
	| need to be fix and if in package has flight the 
	| it is possiblity to dates can be change
	*/
	public function fixDates($routeId=null)
	{
		$routes = null;
		$where = [
				['status', '<>', 'deleted'], 
				['package_id', '=', $this->package_id]
			];

		if (!is_null($routeId)) { 
			$where[] = ['id', '>', $routeId];
		}

		$routes = $this->where($where)->get();
		
		if ($routes->count()) {
			$nextStartDate = '0000-00-00';

			foreach ($routes as $key => $route) {

				if ($key) {
					$route->start_date = $nextStartDate;
				}
				else{
					if ($routeId) {
						$route->start_date = $this->end_date;
					}else{
						$route->start_date = $this->package->start_date;
					}
				} // <- this is for every mode route
				
				if (in_array($route->mode, ['ferry', 'hotel', 'road', 'cruise', 'train'])) {
					$endDate = Carbon::parse($route->start_date);
					$endDate->addDays($route->nights);
					$nextStartDate = $endDate->format('Y-m-d');
					$route->end_date = $nextStartDate;
				}
				
				$route->save();

				if ($route->mode == 'flight') { return true; }
			}
		}
	}


	public function images()
	{
		$images = [];

		if ($this->checkMode('hotel')) {
			//$images = $this->hotel->images();
		}
		elseif ($this->checkMode('cruise')) {
			//$images = $this->cruise->images();
		}
		return $images;
	}


	public function makeQpxRequest()
	{
		return [
				"request" => [
					"slice" => [
						[
							"origin" => $this->origin_code,
							"destination" => $this->destination_code,
							"date" => $this->start_date,
						]
					],
					"passengers" => [
						"adultCount" => 2,
						"infantInLapCount" => 0,
						"infantInSeatCount" => 0,
						"childCount" => 0,
						"seniorCount" => 0
					],
					"solutions" => $this->solutions,
					"refundable" => false
				]
			];
	}


	public function makeTboGuestDetails()
	{
		$guestDetils = $this->roomGuests
										->pluck('tbo_guest_details');
		
		if (!$guestDetils->count()) {
			$guestDetils = collect([
						[
								"NoOfAdults" => 2,
								"NoOfChild" => 0,
								"ChildAge" => collect()
							]
					]);
		}

		return $guestDetils;
	}


	public function makeTboHotelRequest($params = [])
	{
		$preferredHotel = array_get($params, 'PreferredHotel', '');
		if (!isset($this->destination_detail->tbo_destination) && is_null($this->destination_detail->tbo_destination)) {
			return null;
		}

		$dest = $this->destination_detail->tbo_destination;

		$maxRating = isset($request->max_rating) 
							 ? $request->max_rating 
							 : 5;
		$minRating = isset($request->min_rating) 
							 ? $request->min_rating 
							 : 3;

		return [
				"EndUserIp" => $_SERVER['REMOTE_ADDR'],
				"TokenId" => 'XXXX-XXXXX-XXXXX-XXXX', // must set in tbtq
				"CheckInDate" => $this->start_datetime->format('d/m/Y'),
				"NoOfNights" => $this->nights,
				"CountryCode" => $dest->country_code,
				"CityId" => (int) $dest->destination_code,
				"ResultCount" => 50,
				"PreferredCurrency" => "INR",
				"GuestNationality" => "IN",
				"NoOfRooms" => $this->makeTboGuestDetails()->count(),
				"RoomGuests" => $this->makeTboGuestDetails(),
				"PreferredHotel" => $preferredHotel, // name of hotel
				"MaxRating" => $maxRating, // star rating
				"MinRating" => $minRating, // star rating
				"ReviewScore" => 0,
				"IsNearBySearchAllowed" => 0,
				// "SortBy" => "Price",// like "Sort by Price, Star Rating"
				// "Order" => "Ascending",// int like "Ascending or Descending Order"
			];
	}


	/*
	// if mode is flight then this will return else will null
	public function flightDetail()
	{
		$result = null;

		if ($this->checkMode('flight') && !is_null($this->fusion)) {
			$result = $this->fusion->flightDetail();
		}

		return $result;
	}


	public function hotelDetail()
	{
		$result = null;
		if ($this->checkMode('hotel')  && !is_null($this->fusion)) {
			$result = $this->fusion->hotelDetail();
			$result->nights = $this->nights;
			$result->location = $this->destination_detail->location;
			$result->endDate = $this->end_datetime->format('d-M-Y');
			$result->startDate = $this->start_datetime->format('d-M-Y');
			$result->summary = $this->summaryString($result->name);
		}
		return $result;
	}


	public function cruiseDetail()
	{
		$result = null;
		if ($this->checkMode('cruise') && !is_null($this->fusion)) {
			$params = [
							'cityId' => $this->destination_detail->id,
							'nights' => $this->nights
						];
			$result = $this->fusion->cruiseDetail($params);
			$result->nights = $this->nights;
			$result->location = $this->destination_detail->location;
			$result->endDate = $this->end_datetime->format('d-M-Y');
			$result->startDate = $this->start_datetime->format('d-M-Y');
			$result->summary = $result->name;
		}
		return $result;
	}
	*/

}
