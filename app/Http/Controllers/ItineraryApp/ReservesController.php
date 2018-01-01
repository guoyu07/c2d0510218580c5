<?php

namespace App\Http\Controllers\ItineraryApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ItineraryApp\ReserveModel;
use App\Http\Controllers\B2bApp\PackageController;
use App\Traits\CallTrait;
use Carbon\Carbon;

class ReservesController extends Controller
{
	use CallTrait;
	
	public function model()
	{
		return new ReserveModel;
	}

	public function reserve($token, Request $request)
	{
		$validator = \Validator::make($request->all(), [
      'name' => 'required|max:255',
			'email' => 'required|email|max:255',
			'mobile' => 'required|max:255',
			'date' => 'required|date_format:d/m/Y',
			'pax' => 'required|max:255|numeric',
    ]);

    if ($validator->fails()) {
			return jsonResponse(500, 'error', ['errors' => $validator->errors()]);
    }

		$package = PackageController::call()->model()
								->byToken($token)->firstOrFail();

		$date = is_null($request->date) 
					? Carbon::now()
					: Carbon::createFromFormat('d/m/Y', $request->date);

		$reserve = $this->model();
		$reserve->package_id = $package->id;
		$reserve->name =  $request->name;
		$reserve->email =  $request->email;
		$reserve->mobile =  $request->mobile;
		$reserve->date =  $date->toDateString();
		$reserve->pax =  $request->pax;
		$reserve->save();

		if ($request->format == 'json') {
			return jsonResponse();
		}
		else{
			$back = is_null($request->back) 
						? route('yourPackage', [$token])
						: $request->back;

			return redirect($request->back);
		}
	}
}