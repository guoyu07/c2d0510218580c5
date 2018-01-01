<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\ClientController;
use App\Http\Controllers\B2bApp\CruisesController;
use App\Http\Controllers\B2bApp\HotelsController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\B2bApp\ActivitiesController;
use App\Models\B2bApp\PackageModel;
use App\Traits\CallTrait;


class ItineraryController extends Controller
{
	use CallTrait;

	public function itineraryByRoute($packageDbId)
	{
		$package = PackageController::call()->model()->find($packageDbId);
		return $this->itinerary($package);
	}

	public function itinerary(PackageModel $package)
	{
		$itinerary = [];
		foreach ($package->routes as $routeKey => $route) {
			$routeStartDate = $route->start_datetime->format('Y-m-d');
			$routeStartTime = $route->start_datetime->format('H:i');
			$routeEndDate = $route->end_datetime->format('Y-m-d');
			$routeEndTime = $route->end_datetime->format('H:i');
			$origin = $route->origin_detail->destination;
			$destination = $route->destination_detail->destination;

			if ($route->checkMode('flight')) {
				$flights = $route->flightDetail();
				foreach ($flights as $key => $flight) {
					$origin = $flight->origin;
					$originCode = $flight->originCode;
					$destination = $flight->destination;
					$destinationCode = $flight->destinationCode;
					$departureDate = $flight->departureDate;
					$departureTime = $flight->departureTime;
					$arrivalDate = $flight->arrivalDate;
					$arrivalTime = $flight->arrivalTime;

					$itinerary[$departureDate]['flight'] = true;
					$itinerary[$departureDate]['location'][$originCode] = $origin;
					$itinerary[$departureDate]['body'][] = [
								'flight' => 'Board a flight from '.$origin.'('.$departureTime.').'
							];

					$itinerary[$arrivalDate]['flight'] = true;
					$itinerary[$arrivalDate]['location'][$destinationCode] = $destination;
					$flightLine = '';
					if (count($flights) == ($key+1)) {
						$flightLine = 'Land ';
					}
					else{
						$flightLine = 'Arrived ';
					}
					$flightLine .= 'at '.$destination.'('.$arrivalTime.').';

					$itinerary[$arrivalDate]['body'][] = ['flight' => $flightLine];
				}
			}
			elseif ($route->checkMode('hotel')) {
				$hotel = $route->hotelDetail();
				$nights = $route->nights;
				$hotelName = $hotel->name;
				$hotelDate = $route->start_datetime->format('Y-m-d');
				$hotelLocation = $route->destination_detail;
				$hotelImages = $route->images();

				for ($i=1; $i <= $nights+1; $i++) {
					$mode = $route->mode;
					$itinerary[$hotelDate][$mode] = true;
					$itinerary[$hotelDate]['location'][] = $hotelLocation->destination;

					if ($i == 1) {
						if ($route->is_pick_up) {
							$itinerary[$hotelDate]['body'][] = [
									'car' => 'You shell be met by our representative.'
								];
						}

						$itinerary[$hotelDate]['body'][] = [
								'hotel' => 'Then transfer to the '.$mode.' arrive at the '.$hotelName.'('.$mode.') after check in, take some rest.'
							];
					}
					elseif ($i > $nights) {
						$itinerary[$hotelDate]['body'][] = [
								'hotel' => 'Check out from '.$hotelName.'('.$mode.')'
							];
						if ($route->is_drop_off) {
							$itinerary[$hotelDate]['body'][] = [
									'car' => 'Drop to '.$route->drop_off
								];
						}
					}
					else{
						$itinerary[$hotelDate]['body'][] = [
							'hotel' => 'Breakfast will be served at the '.$hotelName.'('.$mode.')'
						];
					}

					
					if ($i <= $nights) {
						if (isset($itinerary[$hotelDate]['hotelImages'])) {
							$itinerary[$hotelDate]['hotelImages'] = 
											array_merge($itinerary[$hotelDate]['hotelImages'], $hotelImages);
						}
						else{
							$itinerary[$hotelDate]['hotelImages'] = $hotelImages;
						}
					}else{
						if (isset($itinerary[$hotelDate]['hotelCheckOutImages'])) {
							$itinerary[$hotelDate]['hotelCheckOutImages'] = 
											array_merge($itinerary[$hotelDate]['hotelCheckOutImages'], $hotelImages);
						}
						else{
							$itinerary[$hotelDate]['hotelCheckOutImages'] = $hotelImages;
						}
					}

					$hotelDate = addDaysinDate($hotelDate,1);
					$hotelImages[] = array_shift($hotelImages);
				}
				
				//=========================Activities here=========================
				if ($route->packageActivities->count()) {

					$tempActivities = [];

					foreach ($route->packageActivities as $packageActivity) {
						$activity = $packageActivity->activityObject(['images']);
						$date = $activity->date;
						$tempActivities[$date]['names'][] =  $activity->name;
						if (!isset($tempActivities[$date]['activityImages'])) {
							$tempActivities[$date]['activityImages'] = [];
							$itinerary[$date]['activities'] = [];
						}
						$tempActivities[$date]['activityImages'] = array_merge(
												$tempActivities[$date]['activityImages'],
												$activity->images
											);
						$itinerary[$date]['activities'][] = $activity;
					}

					// pushing temp activities in to itinarary
					foreach ($tempActivities as $tempActivityKey => $tempActivity) {
						$itinerary[$tempActivityKey]['body'][] = [ 
								'activity' => 'Depart for exciting activities'
										// .' ('.implode(', ', $tempActivity['names']).').'
							];

						if (isset($itinerary[$tempActivityKey]['activityImages'])) {
							$itinerary[$tempActivityKey]['activityImages'] = 
									array_merge($itinerary[$tempActivityKey]['activityImages'], 
									$tempActivity['activityImages']);
						}
						else{
							$itinerary[$tempActivityKey]['activityImages'] = $tempActivity['activityImages'];
						}
					}
				}
			}
			elseif ($route->checkMode('cruise')) {
				$cruise = $route->cruiseDetail();
				$nights = $route->nights;
				$days = $nights+1;
				$cruiseName = $cruise->name;
				$cruiseDate = $route->start_datetime->format('Y-m-d');
				$cruiseLocation = $route->destination_detail;
				$cruiseImages = $route->images();
				$fakeObject = fakeObject();
				for ($i=1; $i <= $days; $i++) {
					$mode = $route->mode;
					$itinerary[$cruiseDate][$mode] = true;
					$itinerary[$cruiseDate]['location'][] = $cruiseLocation->destination;
					$cruiseItinerary = isset($cruise->itinerary[$i-1])
													 ? $cruise->itinerary[$i-1]
													 : $fakeObject;
					if ($i == 1) {
						if ($route->is_pick_up) {
							$itinerary[$cruiseDate]['body'][] = [
									'car' => 'Pick Up from '.$route->pick_up
								];
						}

						$itinerary[$cruiseDate]['body'][] = [
								'cruise' => 'Then transfer to the '.$cruiseItinerary->port.' port check in into '.$cruiseName.'(cruise), take some rest. your cruise will be depart at ('.$cruiseItinerary->etd->format('h:i A').') enjoy your vacation.'
							];
					}
					elseif ($i > $nights) {
						$cruiseLine = 'Have your breakfast, your cruise will be arrive on '.$cruiseItinerary->port.' port at ('.$cruiseItinerary->eta->format('h:i A').') Check out from cruise.';


						if ($route->is_drop_off) {
							$cruiseLine .= 'our representative will meet you there and proceed to '.$route->drop_off;
							/*$itinerary[$cruiseDate]['body'][] = [
									'car' => 'Drop to '.$route->drop_off
								];*/
						}

						$itinerary[$cruiseDate]['body'][] = [
								'cruise' => $cruiseLine,
							];
					}
					else{
						$itinerary[$cruiseDate]['body'][] = [
							'cruise' => 'Enjoy your day on cruise feel the wind of sea. your cruise will be arrive on '.$cruiseItinerary->port.' port at ('.$cruiseItinerary->eta->format('h:i A').') visit this place take a tour and explore then return to the cruise. cruise will be depart at ('.$cruiseItinerary->etd->format('h:i A').') so arrive on cruise before the given time'
						];
					}

					
					if ($i <= $nights) {
						if (isset($itinerary[$cruiseDate]['cruiseImages'])) {
							$itinerary[$cruiseDate]['cruiseImages'] = 
											array_merge($itinerary[$cruiseDate]['cruiseImages'], $cruiseImages);
						}
						else{
							$itinerary[$cruiseDate]['cruiseImages'] = $cruiseImages;
						}
					}
					else{
						if (isset($itinerary[$cruiseDate]['cruiseCheckOutImages'])) {
							$itinerary[$cruiseDate]['cruiseCheckOutImages'] = 
											array_merge($itinerary[$cruiseDate]['cruiseCheckOutImages'], $cruiseImages);
						}
						else{
							$itinerary[$cruiseDate]['cruiseCheckOutImages'] = $cruiseImages;
						}
					}

					$cruiseDate = addDaysinDate($cruiseDate,1);
					$cruiseImages[] = array_shift($cruiseImages);
				}
			}
			elseif ($route->checkMode('ferry')) {
				$itinerary[$routeStartDate]['location'][] = $origin;
				$itinerary[$routeStartDate]['body'][] = [
						'ferry' => 'Board ferry at '.$routeStartTime.' from '.$origin.'.'
					];
				
				$itinerary[$routeEndDate]['location'][] = $destination;
				$itinerary[$routeStartDate]['body'][] = [
						'ferry' => 'Arrived ferry on '.$destination.' at '.$routeEndTime.'.'
					];
			}
			elseif ($route->checkMode('train')) {
				$itinerary[$routeStartDate]['location'][] = $origin;
				$itinerary[$routeStartDate]['body'][] = [
						'train' => 'Board train at '.$routeStartTime.' from '.$origin.'.'
					];
				
				$itinerary[$routeEndDate]['location'][] = $destination;
				$itinerary[$routeStartDate]['body'][] = [
						'train' => 'Arrived train on '.$destination.' at '.$routeEndTime.'.'
					];
			}
			elseif ($route->checkMode('bus')) {
				$itinerary[$routeStartDate]['location'][] = $origin;
				$itinerary[$routeStartDate]['body'][] = [
						'bus' => 'Board bus at '.$routeStartTime.' from '.$origin.'.'
					];
				
				$itinerary[$routeEndDate]['location'][] = $destination;
				$itinerary[$routeStartDate]['body'][] = [
						'bus' => 'Arrived bus on '.$destination.' at '.$routeEndTime.'.'
					];
			}

		}

		$itineraries = [];
		$day = 1;
		foreach ($itinerary as $itineraryKey => &$itineraryValue) {
			$itineraryValue['day'] = $day;
			$itineraryValue['date'] = $itineraryKey;
			if (isset($itineraryValue['location'])) {
				$itineraryValue['location'] = array_values(array_unique($itineraryValue['location']));
			}

			if (!isset($itineraryValue['images'])) {
				$itineraryValue['images'] = [];
			}


			if (isset($itineraryValue['hotelImages']) && isset($itineraryValue['activityImages'])) {
				$itineraryValue['images'] = alternativelyMerge(
									$itineraryValue['hotelImages'], 
									$itineraryValue['activityImages']
								);
			}
			elseif (isset($itineraryValue['hotelImages'])) {
				$itineraryValue['images'] = $itineraryValue['hotelImages'];
			}
			elseif (isset($itineraryValue['activityImages'])) {
				$itineraryValue['images'] = $itineraryValue['activityImages'];
			}
			
			if (isset($itineraryValue['hotelCheckOutImages'])) {
				$itineraryValue['images'] = array_merge(
						$itineraryValue['images'], $itineraryValue['hotelCheckOutImages']);
			}

			$itineraries[] = $itineraryValue;
			$day++;
		}

		return rejson_decode($itineraries);
	}
	
}
