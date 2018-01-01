<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Models\B2bApp\PackageServicePropertyModel;
use App\Models\B2bApp\PackageServiceModel;
use App\Traits\CallTrait;

class PackageServiceController extends Controller
{
	use CallTrait;

	public $route;

	public function model()
	{
		return new PackageServiceModel;
	}


	public function getServicesModelName($key)
	{
		$models = collect([
						'a' => 'App\Models\HotelApp\AgodaHotelModel',
						'b' => 'App\Models\HotelApp\BookingHotelModel',
						'tbo' => 'App\Models\HotelApp\TbtqJsonHotelModel',
					]);

		return $models->get($key);
	}


	public function getServicePropertyModelName($key)
	{
		$models = collect([
						'a' => 'App\Models\HotelApp\AgodaHotelRoomModel',
						'b' => 'App\Models\HotelApp\BookingHotelRoomModel',
						'tbo' => 'App\Models\HotelApp\TboHotelRoomModel',
					]);

		return $models->get($key);
	}




	public function storeService($rToken, Request $request)
	{
		$route = RouteController::call()->model()
						->byToken($rToken)->firstOrFail();

		$service = null;
		$serviceIds = [];

		if ($route->checkMode('hotel')) {
			$packageHotelId = $request->fdid; // PackageHotelModel->id
			$packageHotel = $route->fusion;
			$roomVendor = $request->rmvdr;
			$roomId = $request->rmid;
			$noOfRooms = $request->rooms;

			// getting all route id which is belongs to same service
			$belongWithTo = $route->packageServices
											->pluck('routes.*.id')
												->flatten()->unique();

			// check if service belongs to other route or not
			if ($belongWithTo->count() == 1 && $belongWithTo->first() == $route->id) {

				if (strlen($request->fdid)) {
					$service = $route->packageServices
										->where('id', $request->fdid)
											->first();
				}
				else{
					$service = $route->packageServices
										->where('fusion_id', $request->fid)
											->where('fusion_type', $this->getServicesModelName(
														$request->fvdr
													))
												->first();
				}
			}

			if (is_null($service)) {
				$service = $this->model();
				$service->type = 'hotel';
				$service->fusion_id = $request->fid;
				$service->fusion_type = $this->getServicesModelName($request->fvdr);
				$service->save();
			}

			$serviceIds[] = $service->id;

			// save if own
			if ($roomVendor == 'own' && strlen($roomId)) {
				$enteredRoom = DbHotelsController::call()
												->saveUserInputRooms(
														$request->fvdr,
														$request->fid,
														$request->rty
													);

				$roomId = isset($enteredRoom->id) ? $enteredRoom->id : null;
				$roomVendor = $request->fvdr;
			}


			$packageProps = null;
			if ($service->packageServiceProperties->count()) {

				if (strlen($request->rmdid)) {
					$packageProps = $service->packageServiceProperties
													->where('id', $request->rmdid)
														->first();
				}
				else{
					$packageProps = $service->packageServiceProperties
							->where('property_id', $roomId)
								->where('property_type', 
											$this->getServicePropertyModelName($roomVendor)
										)
									->first();
				}
			}

			if (is_null($packageProps)) {
				$packageProps = new PackageServicePropertyModel;
			}

			$packageProps->package_service_id = $service->id;
			$packageProps->no_of_rooms = $noOfRooms;
			$packageProps->property_id = $roomId;
			$packageProps->property_type = $this->getServicePropertyModelName(
																				$roomVendor
																			);
			$packageProps->save();

			if (!$route->packageServices->where('pivot.package_service_id', $service->id)->count()) {
				$route->packageServices()->attach($serviceIds);
			}

			$route->status = 'complete';
			$route->save();

			return json_encode([
				"fdid" => (int) $service->id,
				"rmdid" => (int) $packageProps->id,
				"rmid" => (int) $roomId,
				"rmvdr" => $roomVendor
			]);
		}

	}



	public function removeServiceProp($rToken, Request $request)
	{
		$route = RouteController::call()->model()
						->byToken($rToken)->firstOrFail();
		
		$serviceIds = [];
		
		$result = [
						"status" => 200, 
						"reponse" => "delete"
					];

		if ($route->checkMode('hotel')) {
			

			// getting all route id which is belongs to same service
			$belongWithTo = $route->packageServices
											->pluck('routes.*.id')
												->flatten()->unique();
			
			$packageServiceProperties = $route->packageServices
													->pluck('packageServiceProperties')
														->flatten()->unique('id')
															->where('id', $request->rmdid)->first();

			if (is_null($packageServiceProperties)) return json_encode($result); 

			// check if service belongs to other route or not
			$result = [
					"fdid" => $packageServiceProperties->package_service_id,
					"rooms" => [],
					"status" => 200, 
					"is_copied" => 0,
					"reponse" => "delete",
				];

			if ($belongWithTo->count() == 1 && $belongWithTo->first() == $route->id) {
				$serviceOld = $route->packageServices
											->where('id', $packageServiceProperties->package_service_id)
												->first();

				$packageServiceProperties->delete();
				
				$serviceOld->refresh();

				if ($serviceOld->packageServiceProperties->count() < 1) {
					$serviceIds[] = $serviceOld->id; 
					$serviceOld->delete();
				}

			}
			else{
				$serviceOld = $route->packageServices
											->where('id', $packageServiceProperties->package_service_id)
												->first();

				if ($serviceOld->packageServices->count() > 1) {
					$service = $this->model();
					$service->type = $serviceOld->type;
					$service->fusion_id = $serviceOld->fusion_id;
					$service->fusion_type = $serviceOld->fusion_type;
					$service->save();

					foreach ($serviceOld->packageServiceProperties as $packageServicePropertiesOld) {
						if ($packageServicePropertiesOld->id != $request->rmdid) {
							$packageRoom = new PackageServicePropertyModel;
							$packageRoom->package_service_id = $service->id;
							$packageRoom->roomtype_code = $packageServicePropertiesOld->roomtype_code;
							$packageRoom->vendor = $packageServicePropertiesOld->vendor;
							$packageRoom->save();

							// old id is key and new id is val
							$result['rooms'][$packageServicePropertiesOld->id] = $packageRoom->id;
						}
					}

					$result['is_copied'] = 1;
				}
			}

			$route->packageServices()->detach($serviceIds);
			$route->refresh();
			if (!$route->packageServices->count()) {
				$route->status = 'active';
				$route->save();
			}

			return json_encode($result);
		}


	}





}
