<?php

namespace App\Http\Controllers\CruiseApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CruiseApp\CttCruiseModel;
use App\Traits\CallTrait;


class CruisesController extends Controller
{
	use CallTrait;

	public function cruises(Array $params)
	{
		if (!isset($params['latitude']) && !isset($params['longitude'])) {
			return [];
		}

		$latitude = array_get($params, 'latitude');
		$longitude = array_get($params, 'longitude');
		$name = array_get($params, 'name', '');
		$skip = array_get($params, 'skip', 0);
		$take = array_get($params, 'take', 20);

		return CttCruiseModel::select()
						->bySearch($name)
							->byLatLong($latitude, $longitude)
								->skip($skip)->take($take)
									->groupBy('itinerary')->get()
										->pluck('built_data')
											/*->unique('description')*/;
	}



	public function cruiseCabinsAndImages(Array $params)
	{
		$id = array_get($params, 'id', null);
		$cruise = CttCruiseModel::find($id);
		if (is_null($cruise)) return [];
		return [
					'cabins' => $cruise->cabin_built_data, 
					'images' => $cruise->images()
				];
	}


}
