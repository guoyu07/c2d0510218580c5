<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;
use Carbon\Carbon;

class PackageFlightModel extends Model
{
	use CallTrait;

	protected $table = 'package_flights';
	protected $appends = [
								'flight_details', 'vendor', 'start_date_time', 'end_date_time'
							];

	public function getVendorAttribute()
	{
		$modelNames = [
				'App\Models\FlightApp\QpxFlightModel' => 'qpx',
				'App\Models\FlightApp\SkyscannerFlightsModel' => 'ss',
				'App\Models\FlightApp\AddedFlightSegmentModel' => 'own'
			];

		return collect($modelNames)->get($this->flight_type);
	}

	public function getFlightDetailsAttribute()
	{
		$details = collect();

		if ($this->vendor == 'qpx') {
			$details = collect($this->flight->flightDetail($this->index));
		}
		elseif ($this->vendor == 'own' && isset($this->flight->built_data)) {
			$details = $this->flight->built_data;
		}

		if (!is_null($this->packageService)) {
			$details->put('package_service_id', $this->packageService->id);
		}

		return $details;
	}


	public function getStartDateTimeAttribute()
	{
		$data = ['date' => null, 'time' => null];
		$dateTime = $this->flight_details->get('departure_date_time');
		if (!is_null($dateTime)) {
			$dateTime = Carbon::parse($dateTime);
			$data['date'] = $dateTime->format('Y-m-d');
			$data['time'] = $dateTime->format('H:i');
		}
		return (object) $data;
	}

	public function getEndDateTimeAttribute()
	{
		$data = ['date' => null, 'time' => null];
		$dateTime = $this->flight_details->get('arrival_date_time');
		if (!is_null($dateTime)) {
			$dateTime = Carbon::parse($dateTime);
			$data['date'] = $dateTime->format('Y-m-d');
			$data['time'] = $dateTime->format('H:i');
		}
		return (object) $data;
	}

	public function flight()
	{
		return $this->morphTo();
	}


	public function packageService()
	{
		return $this->morphOne('App\Models\B2bApp\PackageServiceModel', 'fusion');
	}


}
