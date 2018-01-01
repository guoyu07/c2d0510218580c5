<?php

namespace App\Models\FlightApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommonApp\AirportModel;
use App\Models\FlightApp\AddedFlightModel;
use Carbon\Carbon;


class AddedFlightSegmentModel extends Model
{
	protected $connection = 'mysql7';
	protected $table = 'added_flight_segments';
	protected $appends = [
								'vendor', 'origin', 'destination', 
								'detail', 'built_data',
							];


	public function getCodeAttribute($value)
	{
		return strtoupper($value);
	}

	public function getVendorAttribute()
	{
		return 'own';
	}


	public function getOriginAttribute()
	{
		$name = $this->origin_code;

		if (!is_null($this->originAirport)) {
			$name = $this->originAirport->city.', '
							.$this->originAirport->country;
		}

		return $name;
	}

	

	public function getDestinationAttribute()
	{
		$name = $this->destination_code;

		if (!is_null($this->destinationAirport)) {
			$name = $this->destinationAirport->city.', '
							.$this->destinationAirport->country;
		}

		return $name;
	}


	public function getDetailAttribute()
	{
		return collect([
					'airline_code' => $this->code,
					'airline_name' => $this->name,
					'airline_number' => $this->number,
					'origin' =>  $this->origin,
					'origin_code' => $this->origin_code,
					'destination' => $this->destination,
					'destination_code' => $this->destination_code,
					'arrival_date_time' => $this->arrival_date_time,
					'departure_date_time' => $this->departure_date_time,
				]);
	}


	public function getBuiltDataAttribute()
	{
		return $this->detail->forget([
							'airline_code', 'airline_name', 'airline_number'
							])
						->merge([
							'id' => $this->id,
							'vendor' => $this->vendor,
							'vendor_id' => $this->id,
							'stops' => $this->connections->count(),
							'connections' => $this->connections->pluck('detail'),
							'package_service_id' => $this->package_service_id
					]);
		
	}


	public function getPackageServiceIsAttribute()
	{
		return is_null($this->packageService) 
				 ? null : $this->packageService->id;
	}



	public function connections()
	{
		return $this->hasMany(
											AddedFlightSegmentModel::class, 
											'added_flight_segment_id'
										);
	}


	public function trip()
	{
		$this->hasMany(AddedFlightModel::class, 'added_flight_id');
	}


	public function originAirport()
	{
		return $this->belongsTo(
											AirportModel::class, 
											'origin_code',
											'airport_code'
										);
	}


	public function destinationAirport()
	{
		return $this->belongsTo(
											AirportModel::class, 
											'destination_code',
											'airport_code'
										);
	}


	public function departure()
	{
		return Carbon::parse($this->departure_date_time);
	}


	public function arrival()
	{
		return Carbon::parse($this->arrival_date_time);
	}


	public function removeSegment($id)
	{
		$result = false;
		$segment = $this->find($id);
		if (!is_null($segment)) {
			$segment->is_active = 0;
			$segment->save();
			$result = true;
		}
		return $result;
	}



	public function detailOld()
	{
		return (object)[
					"name" => $this->name,
					"code" => $this->code,
					"flightNumber" => $this->number,
					"departureTime" => $this->departure()->format('h:i'),
					"departureDate" => $this->departure()->format('Y-m-d'),
					"arrivalTime" => $this->departure()->format('h:i'),
					"arrivalDate" => $this->departure()->format('Y-m-d'),
					"origin" => $this->origin,
					"originCode" => $this->origin_code,
					"destination" => $this->destination,
					"destinationCode" => $this->destination_code
				];
	}


}
