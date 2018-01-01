<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\B2bApp\ChildAgeController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Models\B2bApp\RouteRoomMapModel;
use App\Models\B2bApp\RoomGuestModel;
use App\Models\B2bApp\ChildAgeModel;
use App\Traits\CallTrait;


class RoomGuestsController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new RoomGuestModel;
	}

	/*
	| this function is to save room guest data in db
	| object must be like this 
	| $obj = (object)["noOfAdult" = 2, "childAge" => [2, 5, 9]];
	*/
	public function create($pid, $params)
	{
		$roomGuest = new RoomGuestModel;
		$roomGuest->package_id = $pid;
		$roomGuest->no_of_adult = $params->NoOfAdult;
		$roomGuest->save();

		$childAgeParams = [];
		foreach ($params->ChildAge as $childAge) {
			$childAgeParams[] = addDateColumns([
					'room_guest_id' => $roomGuest->id, 
					'age' => $childAge
				]);
		}

		ChildAgeController::call()->model()->insert($childAgeParams);	
	}


	public function createOrUpdateRoom($pToken, Request $request)
	{
		$guestDetails = $request->get('rooms', []);
		$removeRooms = $request->get('remove_rooms', []);
		$package = PackageController::call()->model()
							 ->byUser()->byToken($pToken)
							   ->firstOrFail();

		$mapModel = $package->newOrOldRouteRoomMap();
		if (isset($request->rtoken) && $package->routes->count() > 1) {
			$route = $package->routes->where('token', $request->rtoken)->first();

			if (is_null($route)) {
					$result = $mapModel->roomGuests
										->pluck('guest_details')->toArray();
					return json_encode(['status' => 200, 'response' => $result]);
			}
			else{
				if ($package->routes->where('route_room_map_id', $route->route_room_map_id)->count() > 1 || is_null($route->route_room_map_id)) {
					$mapModel = new RouteRoomMapModel;
					$mapModel->package_id = $package->id;
					$mapModel->is_default = 0;
					$mapModel->save();
					$route->route_room_map_id = $mapModel->id;
					$route->save();
				}
				else{
					$mapModel = $route->routeRoomMap;
				}
			}
		}

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
		$package->syncRoomGuestDetails();

		$result = $mapModel->roomGuests
							->pluck('guest_details')->toArray();

		return json_encode(['status' => 200, 'response' => $result]);
	}

	/*
	| this function here to save multidi array
	|		$roomGuests = [ 
	|				["NoOfAdult" => 2, "ChildAge" => [2, 4, 5]],
	|			];
	*/
	public function createNewMulti($pid, $roomGuests)
	{	
		// this is for be sure that passed params is object 
		$roomGuests = rejson_decode($roomGuests);
		foreach ($roomGuests as $roomGuest) {
			$this->create($pid, $roomGuest);
		}
	}


	public function createOrUpdate($id, Request $request)
	{
		$roomGuest = $this->model()->find($id);

		if (is_null($roomGuest)) {
			$roomGuest = $this->model();
		}

		$roomGuest->rooms = $request->rooms;
		$roomGuest->package_id = $request->package_id;
		$roomGuest->no_of_adult = $request->no_of_adult;
		$roomGuest->save();
		$ids = [];

		foreach ($request->children_age as $childAge) {
			$data = new Request([
								'room_guest_id' => $roomGuest->id, 
								'age' => $childAge['age']
							]);
			$child = ChildAgeController::call()
							->createOrUpdate($childAge['id'], $data);
			$ids[] = $child->id;
		}

		$roomGuest->childAge()->notInIds($ids)->delete();
		return $roomGuest;
	}


	public function destroy($id)
	{
		$roomGuest = $this->model()->byUser()->find($id);
		$roomGuest->childAge()->delete();
		return $roomGuest->delete();
	}


}
