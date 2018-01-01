<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BackendApp\ImagesController;
use App\Http\Controllers\BackendApp\CountryController;
use App\Http\Controllers\BackendApp\DestinationController;
use App\Http\Controllers\BackendApp\ActivityCarsController;
use App\Http\Controllers\BackendApp\ActivityTimingsController;
use App\Http\Controllers\BackendApp\ActivityChildChargesController;
use App\Models\BackendApp\ActivityModel;
use App\Traits\CallTrait;
use DB;



class ActivitiesController extends Controller
{
	use CallTrait;


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		return $this->all($request);
		// $destination = null;
		
		// if (!empty($request->s)) {
		// 	$destination = explode(', ', $request->s);
		// 	$destination = DestinationController::call()->findByDestination($destination[0]);
		// }
		
		// $blade = [
		// 		'destination' => $destination, 
		// 		'rankArray' => ['Cold', 'Medium', 'Hot']
		// 	];

		// return view('backend.protected.dashboard.pages.activity.index', $blade);

	}



	public function all(Request $request)
	{
		$destination = null;
		$activities = null;
		$page = 0;
		$rows = 25;
		if (!is_null($request->page)) {
			$page = $request->page;
		}

		if (!is_null($request->rows)) {
			$rows = $request->rows;
		}		

		if (!empty($request->s)) {
			$destination = explode(', ', $request->s);
			$destination = DestinationController::call()->findByDestination($destination[0]);
			
			$fgfDestinationCode = null;
			if (isset($destination->fgf_destinationcode)) {
				$fgfDestinationCode = $destination->fgf_destinationcode;
			}

			$viatorDestinationCode = null;
			if (isset($destination->viatorDestination->destinationId)) {
				$viatorDestinationCode = $destination->viatorDestination->destinationId;
			}

			$params = (object)[
					'fgfDestinationCode' => $fgfDestinationCode, 
					'viatorDestinationCode' => $viatorDestinationCode,
					'skip' => $page,
					'take' => $rows
				];

			$activities = ActivityModel::call()->allByUnionPage($params); 
		}
		
		$blade = [
				'activities' => $activities, 
				'ranks' => ['Cold', 'Medium', 'Hot'],
				'request' => $request
			];

		return view('backend.protected.dashboard.pages.activity.index', $blade);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$countries = CountryController::call()->all();

		$blade = [
				"countries" => $countries
			];

		return view('backend.protected.dashboard.pages.activity.create', $blade);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		return $this->storeActivity($request);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$activity = $this->getActivityWithAll($id);
		dd_pre_echo($activity);

		if ($activity != null) {

			$blade = [
				"activity" => $activity
			];

			return view('backend.protected.dashboard.pages.activity.show', $blade);	
		}else{
			return view('errors.404');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$countries = CountryController::call()->all();

		$activity = $this->getActivityWithAll($id);	

		if ($activity != null) {
			$blade = [
				"countries" => $countries,
				"activity" => $activity
			];
			return view('backend.protected.dashboard.pages.activity.edit', $blade);
		}else{
			return view('errors.404');
		}

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$this->inactiveActiviyWithAll($id);
		return $this->storeActivity($request);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$this->inactiveActiviyWithAll($id);
		return redirect('/dashboard/activities/');
	}

	public function selectDestination()
	{
		return view('backend.protected.dashboard.pages.activity.select_destination');	
	}

	/*
	| this function for get activity with car, childCharges, images and timing.
	*/
	public function getActivityWithAll($id)
	{
		$activity = ActivityModel::find($id);
		// dd($activity);
		if ($activity->count() > 1) {
			if ($activity->status == 'active') {

				$activityId = $activity->prefix.$activity->id;

				$destination = DestinationController::call()->model();
				$activity->location = $destination->select()
															->where(["fgf_destinationcode" => $activity->destinationCode])
															->first();

				// ==================Activity Images Here==================
				$imagesObj = ImagesController::call()->model();
				$activity->images = $imagesObj->select()->where(["relationId" => $activityId])->get();
				
				// ===================Activity Cars Here=================== 
				$carsObj = ActivityCarsController::call()->model();
				$activity->cars = $carsObj->select()->where(["activityId" => $activityId])->get();

				// ==================Activity Timings Here=================
				$timingObj = ActivityTimingsController::call()->model();
				$activity->timing = $timingObj->select()->where(["activityId" => $activityId])->get();

				// ===============Activity ChilsCharges Here===============
				$childChargesObj = ActivityChildChargesController::call()->model();
				
				$childCharges = $childChargesObj->select()
												->where(["activityId" => $activityId])->get();

				$activity->childCharges = $childCharges;

				$childChargesTemp = [
					"SIC" => [
							"adult" => $activity->adultTktSic,
							"child" => null,
							"infant" => null,
						],
					"Private" => [
							"adult" => $activity->adultPrice,
							"child" => null,
							"infant" => null,
						],
				];

				if ($childCharges->count() > 0) {
					foreach ($childCharges as $childCharge) {
						$childChargesTemp[$childCharge->type]['infant'] = $childCharge->price;
						
						if ($childCharge->toAge <= 2) {
							$childChargesTemp[$childCharge->type]['infant'] = $childCharge->price;
						}
						else {
							$childChargesTemp[$childCharge->type]['child'] = $childCharge->price;
						}
					}
				}
				
				$activity->charges = rejson_decode($childChargesTemp);
				
				// dd_pre_echo(rejson_decode($activity));
				return $activity;
			}
			else{
				return null;
			}
		}else{
			return null;
		}
	}

	public function rank($id, Request $request)
	{
		ActivityModel::where(['id' => $id])->update(['rank' => $request->index]);
	}


	public function inactiveActiviyWithAll($id)
	{
		$auth = auth()->guard('backend')->user();
		$activity = ActivityModel::find($id);
		$activity->status = "inactive";
		$activity->statusby = $auth->email;

		$activityId = $activity->prefix.$id;

		// =================Deactiveting activity here=================
		$activity->save();


		// ==================Deactiveting Activity Images Here==================
		$imagesObj = ImagesController::call()->model();
		$imagesObj->where(["relationId" => $activityId])
							->update([ "status"=>"Inactive", "statusby" => $auth->username]);
		
		// ===================Deactiveting Activity Cars Here=================== 
		$carsObj = ActivityCarsController::call()->model();
		$carsObj->where(["activityId" => $activityId])
						->update([ "status"=>"Inactive", "statusby" => $auth->username]);

		// ==================Deactiveting Activity Timings Here=================
		$timingObj = ActivityTimingsController::call()->model();
		$timingObj->where(["activityId" => $activityId])
						->update([ "status"=>"Inactive", "statusby" => $auth->username]);

		// ===============Deactiveting Activity ChilsCharges Here===============
		$childChargesObj = ActivityChildChargesController::call()->model();
		$childChargesObj->where(["activityId" => $activityId])
						->update([ "status"=>"Inactive", "statusby" => $auth->username]);

	}


	/*
	| this function for inserting data of activity and to follow dry concept 
	| here not updateing data previous data will be inactive in "status" column 
	*/
	public function storeActivity($request){
		
		$auth = auth()->guard('backend')->user();
		$activity = new ActivityModel;
		$activity->backend_id = $auth->id;
		$activity->countryCode = $request->countryCode;
		$activity->destinationCode = $request->destinationCode;
		$activity->name = $request->activityName;
		$activity->currency = $request->currency;
		$activity->fromDate = date_formatter($request->activityValidFrom, 'd/m/Y');
		$activity->toDate = date_formatter($request->activityValidTo, 'd/m/Y');
		$activity->description = $request->activityDescription;
		

		if ($request->sicAdultPrice != '') {
			$activity->sicStatus = 1;
			$activity->adultTktSic = $request->sicAdultPrice;
		}

		if ($request->privateAdultPrice != '') {
			$activity->privateStatus = 1;
			$activity->adultPrice = $request->privateAdultPrice;
		}
		
		if (isset($request->privateCar) && $request->privateCar != '') {
			$activity->priCabIncl = 1;
			$activity->cabStatus = 1;
		}
		
		$activity->status = 'active';
		$activity->statusby = $auth->username;
		$activity->save();

		$activitySaveData = ActivityModel::find($activity->id);

		$concatId = $activitySaveData->uid;

		$this->storeImage($concatId, $request->images);


		// ====================SIC child and infant charges here==================== 
		if ($request->sicChildPrice != '') {
			$sicChildCharges = ActivityChildChargesController::call()->model();
			$sicChildCharges->activityId = $concatId;
			$sicChildCharges->fromAge = 2;
			$sicChildCharges->toAge = 12;
			$sicChildCharges->type = 'SIC';
			$sicChildCharges->price = $request->sicChildPrice;
			$sicChildCharges->status = 'active';
			$sicChildCharges->statusby = $auth->username;
			$sicChildCharges->save();
		}

		if ($request->sicInfantPrice != '') {
			$sicInfantCharges = ActivityChildChargesController::call()->model();
			$sicInfantCharges->activityId = $concatId;
			$sicInfantCharges->fromAge = 0;
			$sicInfantCharges->toAge = 2;
			$sicInfantCharges->type = 'SIC';
			$sicInfantCharges->price = $request->sicInfantPrice;
			$sicInfantCharges->status = 'active';
			$sicInfantCharges->statusby = $auth->username;
			$sicInfantCharges->save();
		}


		// ====================Private child and infant charges here==================== 
			if ($request->privateChildPrice != '') {
			$privateChildCharges = ActivityChildChargesController::call()->model();
			$privateChildCharges->activityId = $concatId;
			$privateChildCharges->fromAge = 2;
			$privateChildCharges->toAge = 12;
			$privateChildCharges->type = 'Private';
			$privateChildCharges->price = $request->privateChildPrice;
			$privateChildCharges->status = 'active';
			$privateChildCharges->statusby = $auth->username;
			$privateChildCharges->save();
		}

		if ($request->privateInfantPrice != '') {
			$priveteInfantCharges = ActivityChildChargesController::call()->model();
			$priveteInfantCharges->activityId = $concatId;
			$priveteInfantCharges->fromAge = 0;
			$priveteInfantCharges->toAge = 2;
			$priveteInfantCharges->type = 'Private';
			$priveteInfantCharges->price = $request->privateInfantPrice;
			$priveteInfantCharges->status = 'active';
			$priveteInfantCharges->statusby = $auth->username;
			$priveteInfantCharges->save();
		}


		// ============================Storing Cars here============================
		if (isset($request->privateCar) && $request->privateCar != '') {

			foreach ($request->privateCar as $privateCar) {
				$privateCar = makeObject($privateCar);
				$car = ActivityCarsController::call()->model();
				$car->activityId = $concatId;
				$car->carName = $privateCar->carName;
				$car->fromDate = date_formatter($privateCar->carValidFrom , 'd/m/Y', 'Y-m-d');
				$car->toDate = date_formatter($privateCar->carValidTo, 'd/m/Y', 'Y-m-d');
				$car->capacity = $privateCar->carCapcity;
				$car->price = $privateCar->carPrice;
				$car->status = 'active';
				$car->statusby = $auth->username;
				$car->save();
			}
		}

		// ===========================Storing Timing here===========================
		if (isset($request->activityTiming) && $request->activityTiming != '') {
			foreach ($request->activityTiming as $activityTiming) {
				$activityTiming = makeObject($activityTiming);

				$timing = ActivityTimingsController::call()->model();
				$timing->activityId = $concatId;
				$timing->openingTime = $activityTiming->openingTime;
				$timing->closingTime = $activityTiming->closingTime;
				$timing->duration = $activityTiming->duration;
				$timing->status = 'active';
				$timing->statusby = $auth->username;
				$timing->save();
			}
		}

		return json_encode([
							"status" => 200, 
							"nextUrl" => url('dashboard/activities/create'),
							"response" => 'activities added']);

	}






	public function storeImage($uid, $images)
	{
		$auth = auth()->guard('backend')->user();

		if (is_array($images)) {
			foreach ($images as $image) {
	     	$imageDb = ImagesController::call()->model();
	     	$imageDb->relationId = $uid;
				$imageDb->type = 'path';
				$imageDb->imagePath = $image['path'];
				$imageDb->url = $image['host'];
				$imageDb->status = 'active';
				$imageDb->statusby = $auth->username;
				$imageDb->save();
			}
		}

		return true;
	}

	/*
	| !!! this function no longer used 
	| this function for storing images path and url in to the db
	*/
	public function storeImageOld(Request $request)
	{
		$auth = auth()->guard('backend')->user();
		
		$countryCode = $request->countryCode;

		if ($request->img != null) {
			foreach ($request->img as $imgKey => $image) {
	      $imageName = time().$imgKey.'.'.$image->getClientOriginalExtension();
	      $image->move(public_path('images/activity/'.$countryCode.'/'), $imageName);
	     	
	     	$imageDb = ImagesController::call()->model();
	     	$imageDb->relationId = $request->activityId;
				$imageDb->type = 'path';
				$imageDb->imagePath = 'images/activity/'.$countryCode.'/'.$imageName;
				$imageDb->url = '/';
				$imageDb->status = 'active';
				$imageDb->statusby = $auth->username;
				$imageDb->save();
			}
		}

		return redirect('dashboard/activities/create');
	}



}
