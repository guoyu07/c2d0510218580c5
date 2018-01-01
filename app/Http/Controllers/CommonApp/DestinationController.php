<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonApp\DestinationModel;
use App\Models\HotelApp\TbtqDestinationModel;
use App\Traits\CallTrait;

class DestinationController extends Controller
{
	use CallTrait;

	public function model(){
		return new DestinationModel;
	}

	public function tbtqModel()
	{
		return new TbtqDestinationModel;
	}


	public function getDestination(Request $request){
		$tag = $request->tags;
		
		$locations = $this->model()->getLocationRight($request->term, $tag);
		
		if (!$locations->count()) {
			$locations = $this->model()->getLocation($request->term, $tag);
		}

		return $locations->pluck('location')->toJson();
	}


	public function names(Request $request){

		$groupBy = \DB::raw("concat(`destination`, ', ', `country`)");
		if ($request->v == 'tbtq') {
			$locations = $this->tbtqModel()
									->bySearch($request->term)
										->orderBy('destination', 'asc')
											->take(20)->groupBy($groupBy)->get();
		}
		else{
			$locations = $this->model()
									->bySearch($request->term)
										// ->byTag($request->tags)
											->orderBy('destination', 'asc')
												->take(20)->groupBy($groupBy)->get();
		}

		$result = $locations->map(function($item) {
				return [
							'name' => $item->location,
							'code' => $item->id
						];	
			})->unique('name');

		return $result->toJson();
	}


	public function getCountry(){
		$locations = CountryController::call()->getCountry();
		return $locations->pluck('CountryCode')->toJson();
	}


}
