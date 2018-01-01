<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\CruiseApp\CruiseOnlyDatesController;
use App\Models\CruiseApp\CruiseOnlyDateModel;
use App\Models\B2bApp\PackageCruiseModel;
use App\Traits\CallTrait;


class CruisesController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new PackageCruiseModel;		
	}


	/*
	| this function is to get view on the browser using get request
	*/
	public function getCruisesByToken($token)
	{
		$package = PackageController::call()->model()
							->byUser()->byToken($token)->firstOrFail();
		$blade = [
				'package' => $package,
				'client' => $package->client,
			];
		return trimHtml(view('b2b.protected.dashboard.pages.cruises.index', $blade)->render());
	}


	/*
	| this function is to pull data from 
	| and it can be call using http post request
	*/
	public function postOnlyCruise($rid, Request $request)
	{
		$route = RouteController::call()->model()->find($rid);
		$params = [
				'name' 	 => $request->name,
				'nights' => $route->nights,
				'date'	 => $route->start_date, 
				'cityId' => $route->destination_detail->id,
			];

		$result = CruiseOnlyDatesController::call()
							->model()->cruiseFormatted($params);
		$result = (object)['cruises' => $result];

		if ($request->format == 'json') {
			$result = json_encode($result);
		}

		return $result;
	}
	
	public function searchCruiseNames($rid, Request $request)
	{
		$format = $request->format;
		$request->merge(['format' => null]);
		$result =  $this->postOnlyCruise($rid, $request);
		$names = [];
		foreach ($result->cruises as $cruise) {
			$names[] = $cruise->name;
		}

		if ($format == 'json') {
			$names = json_encode($names);
		}
		return $names;
	}

	public function postCruiseCabin(Request $request)
	{
		$params = [
				"id" => $request->fid,
				"vendor" => $request->vdr
			];

		$cabins = [];

		if ($request->vdr == 'f') {
			$cabins = CruiseOnlyDatesController::call()
							->model()->cruiseCabinsWithImages($request->fid);
		}
		return json_encode($cabins);
	}


	public function itinerary()
	{
		$params = [
							'date' => '2017-04-16', 
							'vendor_detail_id' => 1, 
							'nights' => '5'
						];

		CruiseOnlyDateModel::call()->vendorDetial($params);	
	}


	public function postAddCruiseCabin($routeId, Request $request)
	{
		$route = RouteController::call()->model()->find($routeId);
		$packageCruiseId = $request->fid;
		$packageCruise = $this->model()->find($packageCruiseId);
		
		if (is_null($packageCruise)) {
			$packageCruise = $this->model();
			$packageCruise->cruise_code = $request->fid;
			$packageCruise->vendor = $request->fvdr;
			$packageCruise->save();
			$packageCruiseId = $packageCruise->id;

			$route->fusion_id = $packageCruiseId;
			$route->fusion_type = 'App\\Models\\B2bApp\\PackageCruiseModel';
			$route->status = 'complete';
			$route->save();
		}

		$packageRooms = $packageCruise->cabinModel();
		$packageRooms->package_cruise_id = $packageCruise->id;
		$packageRooms->cabintype_code = $request->rmid;
		$packageRooms->vendor = $request->rmvdr;
		$packageRooms->save();

		return json_encode([
				"fdid" => $packageCruiseId,
				"rmdid" => $packageRooms->id
			]);
	}


	public function postRemoveCruiseCabin($rid, Request $request)
	{
		$route = RouteController::call()->model()->find($rid);
		$count = $route->fusionCount($route->fusion_id);
		$result = [
				"fdid" => '',
				"cabins" => [],
				"status" => 200, 
				"is_copied" => 0,
				"reponse" => "delete",
			];

		if ($count > 1) {
			$packageCrusie = $this->model();
			$packageCrusie->hotel_code = $route->fusion->hotel_code;
			$packageCrusie->vendor = $route->fusion->vendor;
			$packageCrusie->save();
			$packageCrusieId = $packageCrusie->id;
			$result['is_copied'] = 1;
			$result['fdid'] = $packageCrusieId;
			if ($route->fusion->packageRooms->count()) {
				foreach ($route->fusion->packageRooms as $packageRoom) {
					if ($packageRoom->id != $request->rmdid) {
						$packageCrusieRoom = $this->model()->cabinModel();
						$packageCrusieRoom->package_cruise_id = $packageCrusieId;
						$packageCrusieRoom->cabintype_code = $packageRoom->roomtype_code;
						$packageCrusieRoom->vendor = $packageRoom->vendor;
						$packageCrusieRoom->save();
						$result['cabins'][$packageRoom->id] = $packageCrusieRoom->id;
					}
				}
			}
			$route->fusion_id = $packageCrusie->id;
			$route->fusion_type = 'App\\Models\\B2bApp\\PackageCrusieModel';
			$route->status = 'complete';
			$route->save();
		}
		else {
			$this->model()->cabinModel()->destroy($request->rmdid);
		}

		return json_encode($result);
	}



}
