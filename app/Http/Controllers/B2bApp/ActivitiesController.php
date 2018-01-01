<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\B2bApp\FgfActivitiesController;
use App\Http\Controllers\B2bApp\ViatorActivitiesController;
use App\Http\Controllers\B2bApp\SelectedActivitiesController;
use App\Http\Controllers\ActivityApp\ActivityController;
use App\Http\Controllers\ActivityApp\AgentActivitiesController;
use App\Models\B2bApp\PackageActivityModel;
use App\Models\B2bApp\PackageServiceModel;
use App\Traits\CallTrait;

class ActivitiesController extends Controller
{
	use CallTrait;

	/*
	| this function is to return the model 
	*/
	public function model()
	{
		return new PackageActivityModel;
	}


	/*
	| this function is to create new row in activity table
	| $params = (object)[
	|		"byHotelId" => boolean // if this is true then only hotel id required
	|		"packageDbId" => null,
	|		"hotelId" => null,
	|		"cityId" => null,
	|		"startDate" => null,
	|		"endDate" => null,
	|		"location" => null,
	|	];
	*/
	public function createNew($params = [], $onlyId = false)
	{
		/*$packageActivity = $this->isExist($params->route_id);
		
		if (is_null($packageActivity)) {
			$packageActivity = new PackageActivityModel;
		}*/

		// $packageActivity->route_id = $params->route_id; // removed bcoz route_package_modes
		
		$packageActivity = new PackageActivityModel;
		$packageActivity->status = 'active';
		$packageActivity->save();
		
		if ($onlyId) {
			$packageActivity = $packageActivity->id;
		}

		return $packageActivity;
	}


	/*
	| this function for checking route already exist 
	| or not behalf of route table id because one route 
	| can contain only one row in db
	*/
	public function isExist($rid)
	{
		$packageActivity = $this->model()
											->where(["route_id" => $rid])
												->get();

			return $packageActivity;
	}


	/*
	| this function is to get view on the browser using get request
	*/
	public function getActivitiesByToken($token, Request $request)
	{
		$package = PackageController::call()->model()
							->byUser()->byToken($token)->firstOrFail();

		$activityRoutes = $package->activityRoutes;

		if (is_array($request->only) && !empty($request->only)) {
			$activityRoutes = $activityRoutes->filter(function($item) use ($request){
				if (in_array($item->token, $request->only)) {
					return $item;
				}
			})->values();
		}

		if (!$activityRoutes->count()) {
			$activityRoutes = $package->activityRoutes;
		}

		$viewPath = 'b2b.protected.dashboard.pages.activities';
		$blade = [
				'package' => $package,
				'client' => $package->client,
				'viewPath' => $viewPath, 
				'indication' => indication(),
				'activityRoutes' => $activityRoutes
			];
		return trimHtml(view($viewPath.'.index', $blade)->render());
	}


	public function postFatchActivities($rToken, Request $request){
		/*$selectedActivities = $this->selectedActivities($rid)
													->sortBy('date');*/

		$route = RouteController::call()->model()
						->byPackageUser()->byToken($rToken)->firstOrFail();

		$activities = ActivityController::call()
										->activities($route->destination_detail->id);
		$result = ['activities' => $activities];

		if ($request->format == 'json') {
			return json_encode($result);
		}

		return $result;
	}


	public function getActivityNames($rid, Request $request)
	{
		$name = $request->term;
		$route = RouteController::call()->model()->find($rid);
		$names = ActivityController::call()
									->activityNames($route->destination_detail->id, $name);

		if ($request->format == 'json') {
			$names = json_encode($names);
		}
		return $names;
	}

	public function postActivitiesSearch($rToken, Request $request)
	{
		$name = $request->term;
		$route = RouteController::call()->model()
						->byPackageUser()->byToken($rToken)->firstOrFail();

		$activities = ActivityController::call()
									->activities($route->destination_detail->id, $name)
										->values();

		return json_encode($activities);
	}

	public function postAddActivity($rToken, Request $request)
	{
		$route = RouteController::call()->model()
						->byToken($rToken)->byPackageUser()->firstOrFail();

		$service = $route->packageServices
							->where('id', $request->package_service_id)->first();
		
		$isNew = false;

		if (isset($packageService->fusion->activity)) {
			$packageActivity = $packageService->fusion;
		}
		else{
			$isNew = true;
			$packageActivity = $this->model();
		}

		$date = date_formatter($request->date, 'd/m/Y');

		$relModels = collect([
						'f' => 'ActivityModel',
						'v' => 'ViatorActivityModel',
						'own' => 'AgentActivityModel',
					]);
		
		$activityType = 'App\\Models\\ActivityApp\\'
									.$relModels->get($request->activity_vendor, 'ErrorModel');

		$packageActivity->mode = $request->mode;
		$packageActivity->date = $date;
		$packageActivity->activity_id = $request->activity_id;
		$packageActivity->activity_type = $activityType;
		$packageActivity->pick_up = $request->pick_up;
		$packageActivity->duration = $request->duration;
		$packageActivity->is_fullday = (int) $request->is_fullday;
		$packageActivity->is_morning = (int) $request->is_morning;
		$packageActivity->is_noon = (int) $request->is_noon;
		$packageActivity->is_evening = (int) $request->is_evening;
		$packageActivity->save();

		if ($isNew) {
			$service = new PackageServiceModel;
			$service->type = 'activity';
			$service->fusion_id = $packageActivity->id;
			$service->fusion_type = PackageActivityModel::class;
			$service->save();

			$route->packageServices()->attach([$service->id]);
		}
		$route->status = 'complete';
		$route->save();

		return json_encode([
								'status' => 200, 
								'psid' => $service->id ,
								'pdid' => $packageActivity->id
							]);
	}


	public function postRemoveActivity($rToken, Request $request)
	{
		$route = RouteController::call()->model()
						->byToken($rToken)->byPackageUser()->firstOrFail();
		
		$packageService = $route->packageServices
											->where('id', $request->psid)->first();
		if (!is_null($packageService)) {
			$serviceIds[] = $packageService->id;
			$packageService->delete();
			$route->packageServices()->detach($serviceIds);
		}

		return json_encode(['status' => 200, 'response' => 'deleted']);
	}


	public function postAddActivityOld($rid, Request $request)
	{
		// dd($request->input(), $request->pick_up, $request->duration);
		$packageActivity = $this->model()->find($request->pdid);
		
		if (is_null($packageActivity)) {
			$packageActivity = $this->model();
		}

		if (isset($request->isAdded) && $request->isAdded) {
			$route = RouteController::call()->model()->find($rid);
			$data = $request->input();
			$data['cityId'] = $route->destination_detail->id;
			$request->code = AgentActivitiesController::call()
												->insertOwnActivities($data);
			$request->vendor = 'own';
		}

		$date = date_formatter($request->date, 'd/m/Y');

		$relModels = [
				'f' => 'ActivityModel',
				'v' => 'ViatorActivityModel',
				'own' => 'AgentActivityModel',
			];
		
		$activityType = isset($relModels[$request->vendor])
									? 'App\\Models\\ActivityApp\\'.$relModels[$request->vendor]
									: '';

		$packageActivity->route_id = $rid;
		$packageActivity->mode = $request->mode;
		$packageActivity->date = $date;
		$packageActivity->activity_id = $request->code;
		$packageActivity->activity_type = $activityType;
		$packageActivity->timing = $request->timing;
		$packageActivity->pick_up = $request->pick_up;
		$packageActivity->duration = $request->duration;
		$packageActivity->save();

		return json_encode(['status' => 200, 'pdid' => $packageActivity->id]);
	}

	public function postRemoveActivityOld($rid, Request $request)
	{
		if ($request->pdid) {
			$packageActivity = $this->model()->find($request->pdid);
			$packageActivity->is_active = 0;
			$packageActivity->save();
		}

		return json_encode(['status' => 200, 'response' => 'deleted']);
	}



	/*
	| this function is to fatch data date wise
	*/
	public function dateWiseActivity($data)
	{
		$result = [];

		$activitiesResults = $data->activities->activitiesResult;
		foreach ($activitiesResults as $activitiesResult) {
			$activities = $activitiesResult->ActivitySearchResult->ActivityResults;
			foreach ($activities as $activity) {
				$date = date_formatter($activity->date, 'd/m/Y');
				$result[$date][] = $activity->ActivityData;
			}
		}

		return $result;
	}


	public function selectedActivities($rid)
	{
		$data = $this->model()->byIsActive()
										->byRouteId($rid)->get();
		$activities = [];
		foreach ($data as $value) {
			$activity = $value->activityObject();
			if (!is_null($activity)) {
				$activities[$activity->ukey] = $activity;
			}
		}
		return collect($activities);
	}


	/*this function is to merge selected and db actvities*/
	public function mergeActivities($selectedActivities, $activities)
	{
		foreach ($activities as $key => $activity) {
			if (!isset($selectedActivities[$key])) {
				$selectedActivities[$key] = $activity;
			}
		}
		return collect($selectedActivities);
	}




	/*
	| this function is to pull data from Skyscanner api using 
	| SkyscannerHotelApiController and it can be call using http post request
	*/
	public function postViatorActivitiesResult($id)
	{
		$packageActivity = PackageActivityModel::find($id);

		$result = '';

		if (!is_null($packageActivity)) {
			$result = SkyscannerHotelApiController::call()->hotels($packageActivity);
		}

		if (isset($result->db->id)) {
			$packageActivity->skysacanner_temp_hotel_id = $result->db->id;
			$packageActivity->save();
		}

		return json_encode($result);
	}


	public function arrayForBulkInsert($data, $packageActivityId)
	{
		$selectedActivities = [];
		foreach ($data as $activity) {
			$activity = (object) $activity;
			$code = $activity->activityCode;
			
			if ($activity->vendor == 'f') {
				$code = str_replace('ACTV', '', $code);
			}

			$selectedActivities[] = addDateColumns([
					"package_activity_id" => $packageActivityId,
					"code" => $code,
					"mode" => $activity->mode,
					"date" => date_formatter($activity->date, 'd/m/Y'),
					"vendor" => $activity->vendor,
					"timing" => $activity->timing,
				]); 
		}

		return $selectedActivities;
	}

	public function storeActivity($rToken, Request $request)
	{
		$route = RouteController::call()->model()
						->byPackageUser()->byToken($rToken)->firstOrFail();
		$images = collect($request->images);
		$data = [
				'title' => $request->title,
				'pick_up' => $request->pick_up,
				'duration' => $request->duration,
				'description' => $request->description,
				'inclusion' => $request->inclusion,
				'exclusion' => $request->exclusion,
				'city_id' => $route->destination_detail->id,
				'images' => $images->toArray(),
				'is_temp' => $request->is_temp,
			];

		$activity = AgentActivitiesController::call()
								->insertOwnActivities($data);
		
		return json_encode([
								'status' => 200, 
								'activity' => $activity->built_data
							]);
	}


}
