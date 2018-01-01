<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\B2bApp\ClientController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\B2bApp\RoomGuestsController;
use App\Models\B2bApp\PackageActivityModel;
use App\Models\B2bApp\RoomGuestModel;
use App\Models\B2bApp\ChildAgeModel;
use App\Models\B2bApp\RouteModel;
use App\Traits\CallTrait;


class RouteController extends Controller
{
	use CallTrait;
	
	public $viewPath = 'b2b.protected.dashboard.pages.route';

	public function model()
	{
		return new RouteModel;
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($ctoken, $token = null)
	{
		$client = ClientController::call()->model()
							->byUser()->byToken($ctoken)->firstOrFail();

		$packageController = new PackageController;

		if (is_null($token)) {
			$package = $packageController->createTemp($client->id);
			$token = $package->token;
			return redirect()->route('createRoute', [$ctoken, $token]);
		}
		else{
			$package = $packageController->model()
									->byUser()->byToken($token)->first();
		}


		$blade = [
				"client" 		=> $client, 
				"package" 	=> $package,
				"viewPath" 	=> $this->viewPath,
				"routes" 		=> $package->routes,
				"indication" => indication(),
			];

		return view($this->viewPath.'.create', $blade);
	}


	public function packageUpdate($pToken, Request $request)
	{
		$this->routeOrder($pToken, $request);
		
		$newPkg = new PackageController;
		$package = $newPkg->model()->byUser()
							->byToken($pToken)->first();

		$data = new Request([
				"req" => $request->req,
				"start_date" => date_formatter($request->startDate,'d/m/Y'), 
				// "guests_detail" => $this->makeGuestArray($request->roomGuests),
			]);
		// ======updating package here=======
		$package = $newPkg->packageUpdate($package->id, $data);
		$nextEvent = $newPkg->findEvent($pToken);

		return $nextEvent;
	}


	public function updatePackageAttibutes($pToken, Request $request)
	{
		$package = PackageController::call()->model()->byUser()
								->byToken($pToken)->firstOrFail();
		
		if (!is_null($request->req)) {
			$package->req = $request->req;
		}

		if (!is_null($request->title)) {
			$package->title = $request->title;
		}

		if (!is_null($request->start_date)) {
			$date = date_formatter($request->start_date, 'd/m/Y');
			$package->start_date = $date;
		}

		$package->save();

		return json_encode([
							'status' => 200, 'response' => 'saved successfully...'
						]);
	}

	public function storePackageStartDate($pToken, Request $request)
	{
		$newPkg = new PackageController;
		$package = $newPkg->model()->byUser()
							->byToken($pToken)->first();
		$package->start_date = date_formatter($request->startDate,'d/m/Y');
		$package->save();

		return json_encode(['status' => 200, 'saved successfully.']);
	}


	public function storeRow($pToken, Request $request)
	{
		$route = $this->model()->byPackageUser()->find($request->rid);

		if (is_null($route)) { 
			$route = new RouteModel; 
		}

		$package = PackageController::call()->model()
							 ->byUser()->byToken($pToken)->first();

		$mappingId = isset($route->route_room_map_id) 
							&& $route->route_room_map_id != 0
							 ? $route->route_room_map_id
							 : $package->routeRoomMap->id;

		$route->package_id = $package->id;
		$route->route_room_map_id = $mappingId;
		$route->mode = $request->mode;
		$route->order = $request->order;
		$route->origin = isset($request->origin) ? $request->origin : '';
		$route->origin_code = isset($request->origin_code) 
												? $request->origin_code 
												: '';
		$route->destination = $request->destination;
		$route->destination_code = $request->destination_code;
		$route->nights = isset($request->nights) ? $request->nights : 0;
		
		if (isset($request->origin_time)) {
			$route->start_time = timeFull($request->origin_time);
		}

		if (isset($request->destination_time)) {
			$route->end_time = timeFull($request->destination_time);
		}

		if ($route->mode == 'cruise') {
			$route->is_breakfast = 1;
			$route->is_lunch = 1;
			$route->is_dinner = 1;
		}

		$route->fusion_id = '';
		$route->fusion_type = '';
		$route->status = 'active';

		if (in_array($request->mode, ['bus','ferry','train'])) {
			$route->status = 'complete';
		}

		$route->save();
		return $route->id;
	}


	/*
	| this function is to return json 
	| after creating package
	*/
	public function createPackage($id)
	{
		ClientController::call()->activeClient($id);
		
		/*$data = (object)[
				"start_date" => '0000-00-00',
				"end_date" => '0000-00-00', // init temporary
				"req" => ""
			];*/

		$package = PackageController::call()->createTemp($id);

		return json_encode(['id' => $package->id]);
	}



	public function storeRoom($pToken, Request $request)
	{
		$package = PackageController::call()->model()
							 ->byUser()->byToken($pToken)->firstOrFail();

		$childAge = is_array($request->children_age) 
							? $request->children_age
							: [];

		$room = new Request([
				'package_id' => $package->id,
				'rooms' => $request->rooms,
				'no_of_adult' => $request->adults,
				'children_age' => $childAge
			]);
		
		$roomGuests = RoomGuestsController::call()
									->createOrUpdate($request->id, $room);

		return json_encode([
								'status' => 200,
								'id' => $roomGuests->id,
								'age_ids' => $roomGuests->childAgeIds(),
								'response' => 'saved successfully'
							]);
	}


	public function createOrUpdateRoom($pToken, Request $request)
	{
		$guestDetails = $request->get('rooms', []);
		$removeRooms = $request->get('remove_rooms', []);
		$package = PackageController::call()->model()
							 ->byUser()->byToken($pToken)
							   ->firstOrFail();

		$mapModel = $package->newOrOldRouteRoomMap();
		// removing rooms form database
		foreach ($removeRooms as $roomGuestId) {
			$roomGuest = $mapModel->roomGuests
									->where('id', $roomGuestId)->first();

			if (!is_null($roomGuest)) {
				$roomGuest->childAge()->delete();
				$roomGuest->delete();
				$mapModel->refresh();
			}
		}

		foreach ($guestDetails as $guestDetail) {
			$guestDetail = collect($guestDetail);
			$roomGuest = $mapModel->roomGuests
									->where('id', $guestDetail->pull('id'))
										->first();

			if (is_null($roomGuest)) $roomGuest = new RoomGuestModel;

			$roomGuest->package_id = $package->id;
			$roomGuest->route_room_map_id = $mapModel->id;
			$roomGuest->no_of_adult = $guestDetail->get('adults', 2);
			$roomGuest->save();

			foreach ($guestDetail->get('kids_age', []) as $kid) {
				$kid = collect($kid);
				$childAge = $roomGuest->childAge
										->where('id', $kid->pull('id'))
											->first();

				if (is_null($childAge)) $childAge = new ChildAgeModel;
				$childAge->room_guest_id = $roomGuest->id;
				$childAge->age = $kid->get('age', 2);
				$childAge->is_bed = $kid->get('is_bed', 0);
				$childAge->save();
			}
		}
		$mapModel->refresh();

		$result = $mapModel->roomGuests
							->pluck('guest_details')->toArray();

		return json_encode(['status' => 200, 'response' => $result]);
	}


	public function removeRoom($id)
	{
		RoomGuestsController::call()->destroy($id);
		return json_encode([
								'status' => 200,
								'response' => 'deleted successfully'
							]);
	}



	public function routeOrder($pToken, Request $request)
	{
		$package = PackageController::call()->model()
							 ->byUser()->byToken($pToken)
							   ->firstOrFail();

		if (isset($request->order) && is_array($request->order)) {
			foreach ($request->order as $value) {
				if (isset($value['rid']) && isset($value['order'])) {
					$route = $package->routes
									->where('id', $value['rid'])
										->first();
					if (!is_null($route)) {
						$route->order = $value['order'];
						$route->save();
					}
				}
			}
		}

		return json_encode(['status' => 200, 'response' => 'done']);
	}


	public function inactiveByPackageId($pid)
	{
		$result = $this->model()->byPackageId($pid)
										->update(['status' => 'inactive']);
		return $result; 
	}



	/*
	| this function is to find route by using package table id 
	public function allByPackageId($pid)
	{
		return $this->model()->byPackageId($pid)->get();
	}
	*/


	public function updateRoute($id, Request $request)
	{
		$route = $this->model()->findOrFail($id);

		if (isset($request->origin)) { 
			$route->origin = $request->origin; 
		}

		if (isset($request->destination)) { 
			$route->destination = $request->destination; 
		}

		if (isset($request->origin_code)) { 
			$route->origin_code = $request->origin_code; 
		}
		
		if (isset($request->destination_code)) { 
			$route->destination_code = $request->destination_code; 
		}

		$route->save();
		$return = $route->id;
		if ($request->format == 'json') {
			$return = json_encode(["status" => 200, "response" => "route updated"]);
		}

		return $return;
	}


	public function postRemoveFusion($id)
	{
		$route = $this->model()->find($id);
		$route->fusion_id = '';
		$route->fusion_type = '';
		$route->status = 'active';
		$route->save();
		return json_encode(['status' => '200', 'reponse' => 'delete']);
	}



	/*
	| if there is no action on route the run this function 
	| this will change the status into "complete" with current user
	*/
	public function complete($id)
	{
		return $this->model()->where('id', $id)
						->update(['status' => 'complete']);
	}


	public function deleteRow($rid)
	{
		$this->model()->destroy($rid); // this is delete the row
		// $this->makeStatusDelete($rid); // this only for making status delete
		return json_encode(['status' => 200, 'response' => 'deleted']);
	}


	public function makeStatusDelete($id)
	{
		$route = $this->model()->find($id);
		if (!is_null($route)) {
			$route->status = 'deleted';
			$route->save();
		}
		return true;
	}



	public function copyRoutes($oldPid, $newPid)
	{
		$routes = $this->model()->byPackageId($oldPid)->get();
		$copyColumns = [
						'mode', 'origin', 'origin_code', 
						'destination', 'destination_code', 'nights', 
						'start_date', 'start_time', 'end_date', 'end_time', 
						'is_pick_up', 'pick_up', 'pick_up_mode', 'is_drop_off', 
						'drop_off', 'drop_off_mode', 'is_breakfast', 'is_lunch', 
						'is_dinner', 'fusion_id', 'fusion_type', 'status'
					];

		foreach ($routes as $route) {
			$newRoute = $this->model();
			$newRoute->package_id = $newPid;
			
			foreach ($copyColumns as $copyColumn) {
				$newRoute->$copyColumn = $route->$copyColumn;
			}

			$newRoute->save();

			if ($route->packageActivities->count()) {
				foreach ($route->packageActivities as $packageActivity) {
					$activity = new PackageActivityModel;
					$activity->route_id = $newRoute->id;
					$activity->mode = $packageActivity->mode;
					$activity->date = $packageActivity->date;
					$activity->timing = $packageActivity->timing;
					$activity->activity_id = $packageActivity->activity_id;
					$activity->activity_type = $packageActivity->activity_type;
					$activity->is_active = $packageActivity->is_active;
					$activity->save();
				}
			}
		}

		return $routes;
	}


	public function makeGuestArray(Array $roomGuests)
	{
		$result = [];
		foreach ($roomGuests as $roomGuest) {
			$childAge = isset($roomGuest['ChildAge'])
								? $roomGuest['ChildAge']
								: [];

			$result[] = [
					"NoOfAdult" => $roomGuest['NoOfAdults'],
					"ChildAge" => $childAge
				];
		}

		return $result;
	}


}