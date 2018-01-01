<?php

namespace App\Http\Controllers\FlightApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FlightApp\AirlineModel;
use App\Traits\CallTrait;
class AirlinesController extends Controller
{
	use CallTrait;
	
	public function model()
	{
		return new AirlineModel;
	}


	public function names(Request $request)
	{
		return $this->model()
									->select('code', 'name', 'country')
										->where([['name', 'like', '%'.$request->term.'%']])
											->limit(10)
												->get()
													->toJson();
	}


}
