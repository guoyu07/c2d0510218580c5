<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\B2bApp\ItineraryController;
use App\Traits\Models\B2bApp\PackageModelTrait;
use App\Models\B2bApp\RouteRoomMapModel;
use App\Models\B2bApp\PackageEventModel;
use App\Models\B2bApp\PackageNoteModel;
use App\Models\B2bApp\PackageCostModel;
use App\Traits\CallTrait;
use Carbon\Carbon;
use DB;


class PackageModel extends Model
{
	use CallTrait, PackageModelTrait;

	protected $table = 'packages';
	protected $hidden = ['created_at', 'updated_at'];
	protected $append = [
								'uid', 'cost', 'nights', 'pax_detail',
								'pax_string', 'itinerary', 'package_url',
								'package_preview_url', 'extra_word', 
								'duration', 'is_start_date_set',
								'places_to_go', 'is_link_generate', 
								'images','bg_images', 'trip_summary', 
								'activities'
							];

	public $costToken = null;


	public function setStatusAttribute($value)
	{
		$this->attributes['status'] = strtolower($value);
	}

	public function getUidAttribute()
	{
		$prefix = $this->client->user->admin->prefix;
		$uid = $prefix.str_pad($this->package_code, 7, '0', STR_PAD_LEFT);
		if ($this->modify_count) {
			$uid .= '-'.num2alpha($this->modify_count-1);
		}
		return $uid; 
	}

	public function getNightsAttribute()
	{
		return $this->routes->sum('nights');
	}

	public function getDurationAttribute()
	{
		return $this->nights.' Nights '.($this->nights+1).'Days';
	}


	public function getStartDateAttribute($value)
	{
		return Carbon::parse($value);
	}

	public function getEndDateAttribute()
	{
		$startDate = $this->start_date;
		$startDate->addDays($this->nights);
		return $startDate;
	}


	public function getIsStartDateSetAttribute()
	{
		return $this->start_date->format('Y') > 2000 ? 1 : 0;
	}


	public function getItineraryAttribute()
	{
		return ItineraryController::call()->itinerary($this);
	}


	public function getExtraWordAttribute()
	{
		$text = null;
		if (!is_null($this->packageNote)) {
			$text = $this->packageNote->note;
		}
		return $text;
	}


	public function getPackagePreviewUrlAttribute()
	{
		$url = null;
		if ($this->is_link_generate) {
			$url = route('package.preview', $this->token).'?ctk='.$this->cost->token;
		}
		return $url;
	}

	public function getPackageUrlAttribute()
	{
		$url = null;
		if ($this->is_link_generate) {
			$url = route('yourPackage', $this->token).'?ctk='.$this->cost->token;
		}
		return $url;
	}


	public function getPaxDetailAttribute()
	{
		$result = ["adult" => 0, "child" => 0, "infant" => 0];
		
		foreach ($this->roomGuests as $key => $value) {
			$result['adult'] += $value->no_of_adult;
			foreach ($value->childAge as $childAge) {
				if ($childAge->age <= 2) {
					$result['infant'] += 1;
				}else{
					$result['child'] += 1;
				}
			}
		}

		return (object) $result;
	}

	public function getPaxStringAttribute()
	{
		$pax = $this->pax_detail;

		$result = [];
		if (isset($pax->adult) && $pax->adult) {
			$result[] = $pax->adult.' '.str_plural('Adult', $pax->adult);
		}

		if (isset($pax->child) && $pax->child) {
			$result[] = $pax->child.' '.str_plural('Child', $pax->child);
		}

		if (isset($pax->infant) && $pax->infant) {
			$result[] = $pax->infant.' '.str_plural('Infant', $pax->infant);
		}

		return implode(', ', $result);
	}

	public function getPlacesToGoAttribute()
	{
		return $this->accomoRoutes
									->pluck('destination_detail.country')
										->unique();
	}


	public function getIsLinkGenerateAttribute()
	{
		return (isset($this->cost->token) && $this->cost->total_cost);
	}


	public function getImagesAttribute()
	{
		return $this->activities->pluck('images')->flatten()
									->merge($this->bg_images)->unique();
	}

	public function getBgImagesAttribute()
	{
		$destinations = $this->routes
										->pluck('destination_detail')
											->unique('id');

		$origin = $this->routes->pluck('origin_detail')->unique('id');
		
		$images = $destinations->pluck('images.*.url')
							->flatten()->merge($origin
								->pluck('images.*.url')->flatten())
									->merge($destinations
										->pluck('countryDetail.images.*.url')
											->flatten())->merge($origin
												->pluck('countryDetail.images.*.url')
													->flatten())->unique()
															->filter(function($item){
																		return !is_null($item);
																	})->values();
		return $images;
	}


	public function getTripSummaryAttribute()
	{
		return collect($this->tripSummary());
	}


	public function getActivitiesAttribute()
	{
		return $this->activityRoutes
									->pluck('packageServices.*.fusion.activity_details')
										->flatten(1)->filter(function($item){
													if (!is_null($item)) {
														return $item;
													}
												})->values();
	}


	public function modifiedCount($code)
	{
		return PackageModel::where('package_code', $code)->count();
	}

	public function modifiable()
	{
		$now = Carbon::now();
		return $this->start_date->gt($now);
	}


	public function scopeByToken($query, $token)
	{
		return $query->where(['token' => $token]);
	}


	public function scopeByClientUser($query)
	{
		return $query->whereHas('client', function ($q){
											$q->byUser();
										});
	}

	public function scopeByUser($query)
	{
		$auth = auth()->user();
		return $query->where(['user_id' => $auth->id]);
	}	


	public function scopeByPackageCode($query, $code)
	{
		return $query->where('package_code', $code);
	}


	public function scopeByIsLocked($query, $isLocked = 1)
	{
		return $query->where('is_locked', $isLocked);
	}



	public function scopeSearch($query, $word)
	{
		return $query->whereHas('client', function ($q) use ($word){
										$q->where('fullname', 'like', '%'.$word.'%')
												->orWhere('mobile', 'like', '%'.$word.'%')
													->orWhere('email', 'like', '%'.$word.'%');
									});
	}


	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');		
	}


	public function roomGuest()
	{
		return $this->hasOne(
											'App\Models\B2bApp\RoomGuestModel', 
											'package_id'
										)
									->with('childAge');
	}

	public function roomGuests()
	{
		return $this->hasMany(
											'App\Models\B2bApp\RoomGuestModel', 
											'package_id'
										)
									->with('childAge');
	}


	public function client()
	{
		return $this->belongsTo('App\Models\B2bApp\ClientModel', 'client_id');		
	}


	/*
	| this function is to get all route which is belongs to package table id
	*/
	public function routes()
	{
		return $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id')
									->where([['status', '<>', 'deleted']])
										->orderBy('order');
	}

	public function packages()
	{
		return $this->hasMany(
											'App\Models\B2bApp\PackageModel',
											'package_code', 'package_code'
										);
	}


	public function packageNote()
	{
		return $this->belongsTo(
											PackageNoteModel::class,
											'package_note_id'
										);
	}


	public function routeRoomMap()
	{
		return $this->hasOne(
												'App\Models\B2bApp\RouteRoomMapModel', 
												'package_id'
											)
										->where('is_default', 1);
	}


	public function routeRoomMaps()
	{
		return $this->hasMany(
												'App\Models\B2bApp\RouteRoomMapModel', 
												'package_id'
											);
	}


	public function syncRoomGuestDetails()
	{
		$routeRoomMapIds = $this->routeRoomMaps
											->where('is_default', '<>', 1)
												->pluck('id')->unique();

		$usedRouteRoomMapIds = $this->routes
													->pluck('route_room_map_id')
														->unique();

		$diff = $routeRoomMapIds->diff($usedRouteRoomMapIds);

		$this->routeRoomMaps->map(function ($item) use ($diff){
			if ($diff->contains($item->id)) {
				$item->roomGuests()->delete();
				$item->delete();
			}
		});

		return $this;
	}




	public function newOrOldRouteRoomMap($isDefault = 0)
	{
		$routeRoomMap = $this->routeRoomMap;
		if (is_null($routeRoomMap)) {
			$routeRoomMap = new RouteRoomMapModel;
			$routeRoomMap->package_id = $this->id;
			$routeRoomMap->is_default = $isDefault;
			$routeRoomMap->save();
		}
		return $routeRoomMap;
	}


	public function packageEvents()
	{
		$result = $this->hasMany(PackageEventModel::class, 'package_id');
		$this->syncEventAndRoute(); // synchronizing event
		return $result;
	}


	public function syncEventAndRoute()
	{
		if (!$this->id) return false;

		$events = $this->routeEvents();
		$hasEventData = PackageEventModel::byPackageId($this->id)->get();

		$grouped = $hasEventData->groupBy('event');

		foreach ($grouped as $group) {
			if ($group->count() > 1) {
				foreach ($group as $key => $value) {
					if ($key) {
						$value->delete();
					}
				}
			}
		}

		$hasEvents = $hasEventData->pluck('event')->unique()->toArray();

		foreach ($events as $event) {
			if (!in_array($event, $hasEvents)) {
				$newEvent = new PackageEventModel;
				$newEvent->package_id = $this->id;
				$newEvent->event = $event;
				$newEvent->is_active = $this->is_link_generate ? 0 : 1; 
				$newEvent->save();
			}
		}

		return true;
	}


	public function routeEvents()
	{
		$mode = $this->routes->pluck('mode')->unique()->toArray();
		$events = [];

		if (count(array_intersect(['flight'],$mode))) {
			$events[] = 'flights';
		}
		
		if (count(array_intersect(['hotel', 'hotel_only', 'cruise'],$mode))) {
			$events[] = 'accommodation';
		}
		
		if(count(array_intersect(['hotel', 'activity_only'], $mode))){
			$events[] = 'activities';
		}

		return $events;
	}	


	public function duplicatePackage($newPackageId)
	{
		$newPackage = PackageModel::findOrFail($newPackageId);

		$this->copyRoomGuests($newPackageId)
						->copyPackageEvents($newPackageId);
		
		$note = isset($this->packageNote->note)
					? $this->packageNote->note : '';

		$packageNote = new PackageNoteModel;
		$packageNote->note = isset($this->packageNote->note)
											 ? $this->packageNote->note : '';
		$packageNote->save();
		
		$newPackage->package_note_id = $packageNote->id;
		$newPackage->save();

		return $this;
	}



	public function copyRoomGuests($pid)
	{
		foreach ($this->roomGuests as $roomGuest) {
			$roomGuest->copyGuests($pid);
		}

		return $this;
	}


	public function copyPackageEvents($pid)
	{
		foreach ($this->packageEvents as $packageEvent) {
			$packageEvent->copyEvent($pid);
		}

		return $this; 
	}


	public function roomGuestsOrDefault()
	{
		return (isset($this->routeRoomMap->roomGuests) 
				&& $this->routeRoomMap->roomGuests
									->pluck('guest_details')->count())

				 ? $this->routeRoomMap->roomGuests
									->pluck('guest_details')

				 : collect([[
						"id"			 => null,
						"adults"	 => 2, 
						"kids" 		 => 0,
						"kids_age" => collect([])
					]]);
	}




	/*
	| this function is to get all hotels which is belongs to this package
	*/
	public function getCostAttribute()
	{
		return $this->tempCost->first();
	}


	public function tempCost()
	{
		$where = is_null($this->costToken) 
					 ? ["is_current" => 1]
					 : ["token" => $this->costToken];

		$costs = $this->hasMany(
								PackageCostModel::class, 
								'package_id'
							);

		return $costs->where($where);
	}

	/*
	| this function is to get all hotels which is belongs to this package
	*/
	public function costs()
	{
		$result = $this->hasMany(
								PackageCostModel::class, 
								'package_id'
							);
		return $result->where([['net_cost', '>', 0]]);
	}



	/*
	| this function is to get all hotels which is belongs to this package
	*/
	public function cars()
	{
		$cars = $this->hasMany(
								'App\Models\B2bApp\PackageCarModel', 
								'package_id'
							);
		return $cars->where(["status" => "complete"]);
	}


	/*
	| this function is to get all route which is belongs to package table id
	*/
	public function activeFlightRoutes()
	{
		return $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id')
									->where(['mode' => 'flight', 'status' => 'active'])
										->orderBy('order');
	}


	public function flightRoutes()
	{
		return $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id')
						->where(['mode' => 'flight', ['status', '<>', 'deleted']])
							->orderBy('order');
	}


	/*
	| this function is to get all route which is belongs to package table id
	*/
	public function activeHotelRoutes()
	{
		return $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id')
									->where(['mode' => 'hotel', 'status' => 'active'])
										->orderBy('order');
	}


	public function hotelRoutes()
	{
		return $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id')
									->where('status', '<>', 'deleted')
										->where(function($q){
												$q->where('mode', '=', 'hotel')
														->orWhere('mode', '=', 'hotel_only');
											})
										->orderBy('order');
	}


	public function activityRoutes()
	{
		return $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id')
									->where('status', '<>', 'deleted')
										->where(function($q){
												$q->where('mode', '=', 'hotel')
														->orWhere('mode', '=', 'activity_only');
											})
										->orderBy('order');
	}


	/*
	| this function is to get all route which is belongs to package table id
	*/
	public function activeCruiseRoutes()
	{
		return $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id')
									->where(['mode' => 'cruise', 'status' => 'active'])
										->orderBy('order');
	}


	public function cruiseRoutes()
	{
		return $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id')
									->where(['mode' => 'cruise'])
										->orderBy('order');
	}

	public function activeAccomoRoutes()
	{
		return $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id')
									->where([['status', '=', 'active']])
										->where(function ($query) {
												$query->orWhere('mode', '=', 'hotel')
																->orWhere('mode', '=', 'hotel_only')
																	->orWhere('mode', '=', 'cruise');
											})
										->orderBy('order');
	}

	public function accomoRoutes()
	{
		return $this->hasMany('App\Models\B2bApp\RouteModel', 'package_id')
									->where([['status', '<>', 'deleted']])
										->where(function ($query) {
												$query->orWhere('mode', '=', 'hotel')
																->orWhere('mode', '=', 'hotel_only')
																	->orWhere('mode', '=', 'cruise');
											})
										->orderBy('order');
	}


	public function fixRouteDates()
	{
		$firstRoute = $this->routes->first();

		if (!is_null($firstRoute)) {
			$firstRoute->start_date = $this->start_date->format('Y-m-d');

			if (!$firstRoute->checkMode('flight')) {
				$firstRoute->end_date = $firstRoute->end_date;
			}

			$firstRoute->save();
			$firstRoute->fixNextDates();
		}
		return true;
	}


	/*public function activities()
	{
		$result = $this->hasManyThrough(
									'App\Models\B2bApp\PackageActivityModel', 
									'App\Models\B2bApp\RouteModel', 
									'package_id', 'route_id', 'id'
								);

		return $result->byIsActive()->orderBy('date', 'asc');
	}*/


	public function createRouteUrl()
	{
		return route('createRoute', [$this->client->token, $this->token]);
	}

	
	public function flightUrl()
	{
		return url('dashboard/package/builder/flights/'.$this->token);
	}


	public function accommodationUrl()
	{
		return url('dashboard/package/builder/accommodation/'.$this->token);
	}


	public function activitiesUrl()
	{
		return url('dashboard/package/builder/activities/'.$this->token);
	}


	public function clientEmailSubject()
	{
		return 'Your package is ready!!! | '.$this->uid;
	}


	public function eventActionUrl($current = null)
	{
		$url = route('openPackage', $this->token);
		
		if (!is_null($current)) {
			$event = $this->packageEvents->where('event', $current)->first();
		}
		else{
			$event = $this->packageEvents->where('is_active', 1)->first();
		}
		
		if (!is_null($event)) $url = $event->eventActionUrl();
		
		return $url;
	}


	public function destinations()
	{
		$dests = [];
		foreach ($this->accomoRoutes as $accomoRoute) {
			$dests[] = $accomoRoute->destination_detail->echo_location;
		}
		return implode(' | ', $dests);
	}


	public function backCurrentNextUrl($currKey = '')
	{
		$routes = $this->routes->pluck('mode')->unique()->all();
		$way = ['route'];
		$urls = [
				'route' => $this->createRouteUrl(),
				'flight' => $this->flightUrl(),
				'accommodation' => $this->accommodationUrl(),
				'activities' => $this->activitiesUrl(),
				'open' => route('openPackage',$this->token)
			];

		if (count(array_intersect(['flight'], $routes))) {
			$way[] = 'flight';
		}
		
		if (count(array_intersect(['hotel', 'hotel_only', 'cruise'], $routes))) {
			$way[] = 'accommodation';
		}
		
		if(count(array_intersect(['hotel', 'activity_only'], $routes))){
			$way[] = 'activities';
		}

		$way[] = 'open';

		$currIndex = array_search($currKey, $way);

		$prevKey = isset($way[$currIndex-1])
						 ? $way[$currIndex-1]
						 : 'route';

		$nextKey = isset($way[$currIndex+1])
						 ? $way[$currIndex+1]
						 : 'open';

		$previous = isset($urls[$prevKey])
							? $urls[$prevKey]
							: $this->createRouteUrl();
		
		$current = isset($urls[$currKey])
						 ? $urls[$currKey]
						 : $this->createRouteUrl();

		$next = isset($urls[$nextKey])
					? $urls[$nextKey]
					: route('openPackage',$this->token);

		return collect([
							'previous' => $previous,
							'current' => $current,
							'next' => $next,
						]);
	}	


	public function transferStringArray()
	{
		$routes = $this->accomoRoutes;
		$data = [];
		$previous = null;
		$next = null;

		foreach ($routes as $key => $route) {

			if (isset($routes[$key+1])) $next = $routes[$key+1];

			$string = '';
			$from = '';
			$to = '';

			$accomoName = implode_as_word(', ', 
											$route->accommodations()
												->pluck('name')->toArray(), ' and ');

			$nextAccomoName = (!is_null($next) 
											&& $next->checkMode('hotel'))
											? implode_as_word(', ', 
												$next->accommodations()
													->pluck('name')->toArray(), ' and ')
											: 'destination';

			$prevAccomoName = (!is_null($previous) 
											&& $previous->checkMode('hotel'))
											? implode_as_word(', ', 
												$previous->accommodations()
													->pluck('name')->toArray(), ' and ')
											: 'destination';


			if ($route->is_pick_up) {
				$string = $route->pick_up_mode.' transfer';
				$from = $route->pick_up;
				$to = $accomoName;

				if ($route->pick_up_mode == 'selfdrive') {
					$string = 'Self drive';
				}
				$string = ucfirst(strtolower($string));

				if ($route->pick_up == 'hotel' && !is_null($previous)) {
					$from = $prevAccomoName;
				}

				$data[] = $string.' from '.$from.' to '.$to.'.'; 
			}


			if ($route->is_drop_off) {
				$string = $route->drop_off_mode.' transfer';

				$from = ($route->checkMode('hotel'))
							? $accomoName
							: $route->mode;

				$to = ($route->drop_off == 'hotel' && !is_null($next))
						? $nextAccomoName
						: $route->drop_off;
				
				if ($route->drop_off_mode == 'selfdrive') {
					$string = 'Self drive';
				}

				$string = ucfirst(strtolower($string));

				$data[] = $string.' from '.$from.' to '.$to.'.'; 
			}

			$previous = $route; // init previous route
		}
		
		return collect($data);
	}


	public function tripSummary()
	{
		$result = [
						'visa' => $this->cost->is_visa,
						'hotels' => [],
						'flights' => [],
						'transfers' => $this->transferStringArray()->toArray(),
						'activities' => [],
						'extra_word' => $this->extra_word
					];

		if ($this->flightRoutes->count()) {
			foreach ($this->flightRoutes as $route) {
				$flightName = $route->flights()
											->pluck('connections.*.airline_name')
												->flatten()->unique()->implode(', ');

				$flightName = trim(str_replace(
								['Limited', 'Ltd'],['', ''], $flightName
							));

				$flightName = strlen($flightName) ? '('.$flightName.')' : '';

				$result['flights'][] = $route->origin_detail->location.' to '
																.$route->destination_detail->location
																	.' flight '.$flightName;
			}
		}

		if ($this->accomoRoutes->count()) {
			foreach ($this->accomoRoutes as $route) {
				$result['hotels'][] = $route->accomoSummaryString();
			}
		}

		if ($this->activities->count()) {
			foreach ($this->activities as $activity) {
				if (!is_null($activity)) {
					$result['activities'][] = $activity->get('name')
						.' '.strtolower($activity->get('mode_name')). ' basis';
				}
			}
		}

		return $result;
	}



	protected static function boot()
	{
		parent::boot();
		
		static::creating(function($model){
			$auth = auth()->user();
			$model->token = new_token(); // setting token
			$model->user_id= $auth->id;
			$model->modify_count = $model->modifiedCount($model->package_code);
			$model->status = 'active';
		});

		static::created(function($model){
			$routeRoomMap = new RouteRoomMapModel;
			$routeRoomMap->package_id = $model->id;
			$routeRoomMap->is_default = 1;
			$routeRoomMap->save();
			
			$newCost = new PackageCostModel;
			$newCost->package_id = $model->id;
			$newCost->save();
		});

	}

}

