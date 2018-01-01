<?php

namespace App\Models\FlightApp;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class QpxFlightModel extends Model
{
	protected $connection = 'mysql7';
	protected $table = 'qpx_flights';
	protected $appends = [
			'airlines', 'cities', 'slices', 'legs', 'segments',
			'departureDateTime', 'arrivalDateTime', 'built_data'
		];
		
	protected $casts = [
			'request' => 'object', 
			'result' => 'object'
		];


	/*==============this function to get all airline code==============*/

	public function getAirlinesAttribute(){
		$airlineCode = [];
		if (isset($this->result->trips->data->carrier)) {
			foreach ($this->result->trips->data->carrier as $airline) {
				$airlineCode[$airline->code] = $airline->name;
			}
		}
		return (object) $airlineCode;
	}


	/*======this function for making index by city code======*/
	public function getCitiesAttribute(){
		$cityCode = [];
		if (isset($this->result->trips->data->city)) {
			foreach ($this->result->trips->data->city as $city) {
				$cityCode[$city->code] = $city->name;
			}
		}
		return (object) $cityCode;
	}



	public function getDepartureDateTimeAttribute()
	{
		$dateTime = (object)['date' => '0000-00-00', 'time' => '00:00'];
		if (isset($this->slices[0]->segment[0]->leg[0]->departureTime)) {
			$departureDateTime = Carbon::parse($this->slices[0]
																	 ->segment[0]->leg[0]
																		 ->departureTime);
			$dateTime->date = $departureDateTime->format('Y-m-d');
			$dateTime->time = $departureDateTime->format('H:i');
		}

		return $dateTime;
	}


	public function getArrivalDateTimeAttribute()
	{
		$dateTime = (object)['date' => '0000-00-00', 'time' => '00:00'];

		$sliceCount = count($this->slices)-1;
		if (isset($this->slices[$sliceCount]->segment)) {
			$segmentCount = count($this->slices[$sliceCount]->segment)-1;

			if (isset($this->slices[$sliceCount]->segment[$segmentCount]->leg)) {
				$legCount = count($this->slices[$sliceCount]
																 ->segment[$segmentCount]->leg)-1;

				// finding end Date here
				$arrivalDateTime = Carbon::parse($this->slices[$sliceCount]
													->segment[$segmentCount]->leg[$legCount]
														->arrivalTime);

				$dateTime->date = $arrivalDateTime->format('Y-m-d');
				$dateTime->time = $arrivalDateTime->format('H:i');
			}
		}

		return $dateTime;
	}



	public function getSlicesAttribute()
	{
		$result = [];
		if (isset($this->result->trips->tripOption)) {
			$result = $this->result->trips->tripOption[$this->selected_index]->slice;
		}
		return $result;
	}


	public function getSegmentsAttribute()
	{
		$slices = $this->slices;
		$cities = $this->cities;
		$airlines = $this->airlines;
		$segments = [];
		foreach ($slices as $slice) {
			foreach ($slice->segment as  $segment) {
				$carrier = $segment->flight->carrier;
				$airlineDetail = $segment->flight;
				$airlineDetail->name = $airlines->$carrier;
				foreach ($segment->leg as $leg) {
					$tempLeg = $leg;
					$tempLeg->airline = $airlineDetail;
					$tempLeg->departureDateTime = getDateTime($leg->departureTime);
					$tempLeg->arrivalDateTime = getDateTime($leg->arrivalTime);

					$originCode = $leg->origin;
					$tempLeg->originCity = isset($cities->$originCode) 
															 ? $cities->$originCode
															 : $originCode;

					$destinationCode = $leg->destination;
					$tempLeg->destinationCity = isset($cities->$destinationCode)
															 ? $cities->$destinationCode
															 : $destinationCode;
					$segments[] = $tempLeg;
				}
			}
		}
		return $segments; 
	}


	public function flightDetail($index)
	{
		$collect = collect(collect($this->toGlobalArray())->get($index));
		$collect->put('connections', collect($collect->get('connections'))
							->map(function ($item){ return collect($item); }));
		return $collect;
	}


	public function flightDetails()
	{
		$slices = $this->slices;
		$cities = $this->cities;
		$airlines = $this->airlines;
		$flightDetails = [];
		foreach ($slices as $slice) {
			foreach ($slice->segment as  $segment) {
				$carrier = $segment->flight->carrier;
				
				$flightDetail = (object)[
						"name" => $airlines->$carrier,
						"code" => $segment->flight->carrier,
						"flightNumber" => $segment->flight->number,
						"departureTime" => '',
						"departureDate" => '',
						"arrivalTime" => '',
						"arrivalDate" => '',
						"origin" => '',
						"originCode" => '',
						"destination" => '',
						"destinationCode" => ''
					];

				foreach ($segment->leg as $leg) {
					$departureDateTime = getDateTime($leg->departureTime);
					$arrivalDateTime = getDateTime($leg->arrivalTime);

					$flightDetail->departureDate = $departureDateTime->date;
					$flightDetail->departureTime = $departureDateTime->time;
					
					$flightDetail->arrivalDate = $arrivalDateTime->date;
					$flightDetail->arrivalTime = $arrivalDateTime->time;

					$originCode = $leg->origin;
					$flightDetail->originCode = $originCode;
					$flightDetail->origin = isset($cities->$originCode) 
																? $cities->$originCode
																: $originCode;

					$destinationCode = $leg->destination;
					$flightDetail->destinationCode = $destinationCode;
					$flightDetail->destination = isset($cities->$destinationCode)
																		 ? $cities->$destinationCode
																		 : $destinationCode;
				}

				$flightDetails[] = $flightDetail;
			}
		}
		return $flightDetails;
	}

	public function tripOption()
	{
		return isset($this->result->trips->tripOption)
		? $this->result->trips->tripOption[$this->selected_index]
		: [];
	}

	/*
	| this function is returning global array which used for view
		$Global_Array =  [
				origin => Delhi
				origin_code => DEL
				destination => Calcutta
				destination_code => CCU
				airline_code => AI
				airline_name => Air India Limited
				airline_number => 401
				arrival_date_time => 2017-05-06 06:50
				departure_date_time => 2017-05-06 06:50
			];
	*/
	public function toGlobalArray()
	{
		$trips = [];
		if (isset($this->result->trips->tripOption)) {
			$cities = $this->cities;
			$airlines = $this->airlines;
			$tripOptions = $this->result->trips->tripOption;
			foreach ($tripOptions as $index => $tripOption) {
				$segments = [];
				$slices = $tripOption->slice;
				foreach ($slices as $slice) {
					foreach ($slice->segment as  $segment) {
						$carrier = $segment->flight->carrier;
						foreach ($segment->leg as $leg) {
							$tempLeg = (object) [];
							$tempLeg->airline_name = $airlines->$carrier;
							$tempLeg->airline_code = $segment->flight->carrier;
							$tempLeg->airline_number = $segment->flight->number;

							$tempLeg->departure_date_time = Carbon::parse($leg->departureTime)
																						->format('Y-m-d H:i');

							$tempLeg->arrival_date_time = Carbon::parse($leg->arrivalTime)
																						->format('Y-m-d H:i');

							$originCode = $leg->origin;
							$tempLeg->origin = isset($cities->$originCode) 
																	 ? $cities->$originCode
																	 : $originCode;
							$tempLeg->origin_code = $originCode;


							$destinationCode = $leg->destination;
							$tempLeg->destination_code = $destinationCode;
							$tempLeg->destination = isset($cities->$destinationCode)
																		? $cities->$destinationCode
																		: $destinationCode;

							$segments[] = $tempLeg;
						}
					}
				}

				$segments = collect($segments);

				$trips[] = collect([
							'id' => $index,
							'vendor' => 'qpx',
							'vendor_id' => $this->id,
							'stops' => $segments->count(),
							'origin' =>  $segments->first()->origin,
							'origin_code' => $segments->first()->origin_code,
							'departure_date_time' => $segments->first()->departure_date_time,
							'destination' => $segments->last()->destination,
							'destination_code' => $segments->last()->destination_code,
							'arrival_date_time' => $segments->last()->arrival_date_time,
							'connections' => $segments
					])->toArray();
			}
		}

		return $trips;
	}



	public function __construct()
	{
		parent::__construct();
		DB::statement('SET wait_timeout=1200;');
	}

}
