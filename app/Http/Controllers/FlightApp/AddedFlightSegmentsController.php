<?php

namespace App\Http\Controllers\FlightApp;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Models\FlightApp\AddedFlightSegmentModel;
use App\Traits\CallTrait;

class AddedFlightSegmentsController extends Controller
{
	use CallTrait;


	public function model()
	{
		return new AddedFlightSegmentModel;
	}


	public function saveFlights(Collection $connections)
	{
		$default = $connections->first();
		$default->put('is_default', 1);
		if ($connections->count() > 1) {
			$default = $default->merge([
					'destination_code' => $connections->last()->get('destination_code'),
					'arrival_date_time' => $connections->last()->get('arrival_date_time'),
				]);
		}

		$default = $this->store(new Request($default->toArray()));

		$connections->map(function ($item) use ($default){
			$item->put('is_default', 0)
							->put('added_flight_segment_id', $default->id);

			return $this->store(new Request($item->toArray()));
		});

		return $default->refresh();
	}


	public function store(Request $segment){
		$cols = [
				'is_default',
				'added_flight_segment_id',
				'name',
				'code',
				'number',
				'origin_code',
				'destination_code',
				'departure_date_time',
				'arrival_date_time',
			];

		$model = $this->model();
		
		foreach ($cols as $col) {
			$model->$col = $segment->$col;
		}

		$model->save();
		return $model;
	}

	public function saveSegments($segments)
	{
		$res = [];
		foreach ($segments as $key => $segment) {
			$segment = (object) $segment;

			$addSegment = null;
			if (isset($segment->vsid)) {
				$addSegment = $this->model()->find($segment->vsid);
			}

			if (is_null($addSegment)) {
				$addSegment = $this->model();
			}

			$addSegment->added_flight_id = $segment->added_flight_id;
			$addSegment->name = $segment->name;
			$addSegment->code = $segment->code;
			$addSegment->number = $segment->number;
			$addSegment->origin_code = $segment->origin_code;
			$addSegment->destination_code = $segment->destination_code;
			$addSegment->departure_date_time = $segment->departure_date_time;
			$addSegment->arrival_date_time = $segment->arrival_date_time;
			$addSegment->save();
			$res[$segment->uid] = $addSegment->id;
		}
		
		return $res;

	}



}


