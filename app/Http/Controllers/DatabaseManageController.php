<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\B2bApp\RouteModel;
use App\Models\B2bApp\PackageFlightModel;
use App\Models\B2bApp\PackageServiceModel;
use App\Models\B2bApp\PackageActivityModel;
use App\Models\B2bApp\PackageServicePropertyModel;
use App\Models\B2bApp\PackageAccommodationModel;
use App\Models\B2bApp\PackageAccommodationPropertyModel;
use App\Models\CommonApp\ChangeSomethingModel;
use App\Traits\CallTrait;

class DatabaseManageController extends Controller
{
	use CallTrait;


	public function syncAccommodationWithPackageService()
	{
		$packageServices = PackageServiceModel::where('type', 'hotel')
											->get();

		$packageServices->map(function ($service){

			$accommo = new PackageAccommodationModel;
			$accommo->accommodation_id = $service->fusion_id;
			$accommo->accommodation_type = $service->fusion_type;
			$accommo->save();

			$service->packageServiceProperties->map(function($serProp) use ($accommo){
				$property = new PackageAccommodationPropertyModel;
				$property->package_accommodation_id = $accommo->id;
				$property->type = $serProp->type;
				$property->no_of_rooms = $serProp->no_of_rooms;
				$property->property_id = $serProp->property_id;
				$property->property_type = $serProp->property_type;
				$property->save();
			});

			$service->type = 'accommodation';
			$service->fusion_id = $accommo->id;
			$service->fusion_type = PackageAccommodationModel::class;
			$service->save();
		});

		$newChange = new ChangeSomethingModel;
		$newChange->stack_id = new_token();
		$newChange->status = 1;
		$newChange->detail = json_encode([
								'package_service_ids' => $packageServices->pluck('id')->toArray()
							]);
		
		$newChange->save();

		return $newChange->detail;
	}


	/*
  |
  | !!!!!!!!! ------ Don't----- ever delete this code or read first
  |
  | syncing all flight related table, used in migration
 	*/
	public function syncActivitesWithPacakgeService()
	{

		$routes = RouteModel::where(function($q){
			$q->where('mode', 'hotel');
			$q->orWhere('mode', 'activity_only');	

		$done = [];
		})->get();		
		$done = [];

		$routes->map(function ($route) use (&$done){
			$route->packageActivities->map(function($pkgAct) use ($route, &$done){
				if (!is_null($pkgAct)) {
					$packageServices = new PackageServiceModel;
					$packageServices->type = 'activity';
					$packageServices->fusion_id = $pkgAct->id;
					$packageServices->fusion_type = PackageActivityModel::class;
					$packageServices->save();
					$route->packageServices()->attach([$packageServices->id]);
					$done[] = $route->id;
				}
			});
		});
		
		$newChange = new ChangeSomethingModel;
		$newChange->stack_id = new_token();
		$newChange->status = 1;
		$newChange->detail = json_encode([
								'all' => $routes->pluck('id')->toArray(),
								'done' => $done,
								'diff' => $routes->pluck('id')->diff($done)->toArray()
							]);
		
		$newChange->save();

		return $newChange->detail;

	}


  /*
  |
  | !!!!!!!!! ------ Don't----- ever delete this code or read first
  |
  | syncing all flight related table, used in migration
 	*/
	public function syncFlightWithPacakgeService()
	{

		$routes = RouteModel::where('fusion_type', 'App\Models\FlightApp\QpxFlightModel')->get();
		$done = [];

		$routes->map(function ($route){
			$qpx = $route->fusion;
			if (!is_null($qpx)) {
				$pacakgeFlight = new PackageFlightModel;
				$pacakgeFlight->flight_id = $qpx->id;
				$pacakgeFlight->flight_type = 'App\Models\FlightApp\QpxFlightModel';
				$pacakgeFlight->index = $qpx->selected_index;
				$pacakgeFlight->save();
				$packageServices = new PackageServiceModel;
				$packageServices->type = 'hotel';
				$packageServices->fusion_id = $pacakgeFlight->id;
				$packageServices->fusion_type = PackageFlightModel::class;
				$packageServices->save();
				$route->packageServices()->attach([$packageServices->id]);
				$done[] = $route->id;
			}
		});

		$newChange = new ChangeSomethingModel;
		$newChange->stack_id = new_token();
		$newChange->status = 1;
		$newChange->detail = json_encode([
								'all' => $routes->pluck('id')->toArray(),
								'done' => $done,
								'diff' => $routes->pluck('id')->diff($done)->toArray()
							]);
		
		$newChange->save();

		return $newChange->detail;

	}




  /*
  |
  | !!!!!!!!! ------ Don't----- ever delete this code or read first
  |
  | syncing all related table, used in migration
 	*/

	public function syncPackageService()
	{
		$routes = RouteModel::where(
										'fusion_type', 
										'App\Models\B2bApp\PackageHotelModel'
									)->get();
		$done = [];
		foreach ($routes as $route) {
			if (!is_null($route->fusion) && $route->fusion->packageRooms->count()) {
				$done[] = $route->id;

				$fusionTypes = collect([
						'a' => 'App\Models\HotelApp\AgodaHotelModel',		
						'b' => 'App\Models\HotelApp\BookingHotelModel',
					]);

				$service = new PackageServiceModel;
				$service->type = 'hotel';
				$service->fusion_id = $route->fusion->hotel_code;
				$service->fusion_type = $fusionTypes->get($route->fusion->vendor);
				$service->save();

				foreach ($route->fusion->packageRooms as $packageRoom) {
					$propertyTypes = collect([
							'a' 	=> 'App\Models\HotelApp\AgodaHotelRoomModel',
							'b' 	=> 'App\Models\HotelApp\BookingHotelRoomModel',
							'own' => 'App\Models\HotelApp\OwnHotelRoomModel'
						]);

					$propertyType = $propertyTypes->get($packageRoom->vendor);

					if (!is_null($propertyType) && $packageRoom->roomtype_code) {
						$newProperty = new PackageServicePropertyModel;
						$newProperty->package_service_id = $service->id;
						$newProperty->type = 'room';
						$newProperty->no_of_rooms = $packageRoom->no_of_rooms;
						$newProperty->property_id = $packageRoom->roomtype_code;
						$newProperty->property_type = $propertyType;
						$newProperty->save();
					}
				}

				$route->packageServices()->attach([$service->id]);
			}
		}

		$newChange = new ChangeSomethingModel;
		$newChange->stack_id = new_token();
		$newChange->status = 1;
		$newChange->detail = json_encode([
								'all' => $routes->pluck('id')->toArray(),
								'done' => $done,
								'diff' => $routes->pluck('id')->diff($done)->toArray()
							]);
		
		$newChange->save();

		return $newChange->detail;
	}
}
