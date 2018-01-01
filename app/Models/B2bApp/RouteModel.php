<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\CommonApp\DestinationController;
use App\Models\HotelApp\AgodaDestinationModel;
use App\Traits\Models\B2bApp\RouteModelTrait;
use App\Models\CommonApp\DestinationModel;
use App\Models\CommonApp\IndicationModel;
use App\Models\CommonApp\AirportModel;
use Carbon\Carbon;


class RouteModel extends Model
{
	use RouteModelTrait;

	protected $table = 'routes';
	protected $appends = [
			'mode_name',
			'end_datetime',
			'origin_detail', 
			'explode_origin',
			'start_datetime', 
			'destination_detail',
			'explode_destination',
			'package_services_formatted',
			'selected_services',
			'route_formatted',
			'guest_details'
		];
	
	/**
	* The attributes that should be hidden for arrays.
	*
	* @var array
	*/
	protected $hidden = [
		'created_at', 'updated_at',
	];


	public function getModeNameAttribute()
	{
		$mode = IndicationModel::byCategory('route_mode')
						->byKey($this->mode)->first();

		return isset($mode->name) 
				 ? $mode->name
				 : str_replace('_', ' ', $this->mode);
	}


	public function setStatusAttribute($value)
	{
		$this->attributes['status'] = strtolower($value);
	}

	public function getOriginDetailAttribute()
	{
		$result = $this->originMorphTo;

		if (is_null($result)/* || $this->checkMode('flight')*/) {
			$location = $this->location($this->explode_origin);
			$result = $this->searchDbLocation($location);
			if (!is_null($result) && !$this->checkMode('flight')) {
				$this->origin_code = $result->id;
				$this->save();
			}
		}
		
		return $result;
	}


	public function getDestinationDetailAttribute()
	{
		$result = $this->destinationMorphTo;
		if (is_null($result)/* || $this->checkMode('flight')*/) {
			$location = $this->location($this->explode_destination);
			$result = $this->searchDbLocation($location);
			if (!is_null($result) && !$this->checkMode('flight')) {
				$this->destination_code = $result->id;
				$this->save();
			}
		}
		return $result;
	}



	public function getOriginCodeAttribute($code)
	{
		if ($this->checkMode('flight') && !strlen($code)) {
			$code = substr($this->attributes['origin'], 0, 3);
			$this->origin_code = $code;
			$this->save();
		}
		return $code;
	}



	public function getDestinationCodeAttribute($code)
	{
		if ($this->checkMode('flight') && !strlen($code)) {
			$code = substr($this->attributes['destination'], 0, 3);
			$this->destination_code = $code;
			$this->save();
		}

		return $code;
	}


	public function getIsDateStaticAttribute()
	{
		return $this->checkMode('flight') ? false : true;
	}


	public function getStartDateAttribute($value)
	{
		return is_null($value) ? '0000-00-00' :$value;
	}

	public function getEndDateAttribute($value)
	{
		return $this->is_date_static 
				 ? $this->start_datetime
									->addDays($this->nights)
										->format('Y-m-d')
				 : $value;
	}	


	public function getStartDatetimeAttribute()
	{
		return Carbon::parse($this->start_date.' '.$this->start_time);
	}


	public function getEndDatetimeAttribute()
	{
		return Carbon::parse($this->end_date.' '.$this->end_time);
	}

	public function getExplodeOriginAttribute()
	{
		return explode(', ', $this->origin);
	}

	public function getExplodeDestinationAttribute()
	{
		return explode(', ', $this->destination);
	}


	public function scopeByToken($query, $token)
	{
		return $query->where('token', $token);
	}


	public function scopeByPackageUser($query)
	{
		return $query->whereHas('package',function ($q){
											$q->byUser();
										});
	}


	public function scopeByPackageId($query, $pid)
	{
		return $query->where(['package_id' => $pid]);
	}


	// this will default find active statused
	public function scopeByStatus($query, $status = 'active', $match = '=')
	{
		return $query->where('status', $match, $status);
	}


	public function searchDbLocation($word)
	{
		$result = DestinationController::call()->model();
		if ($word != ', ') {
			$result = $result->bySearch($word)->first();
		}
		return $result;
	}
	


	public function originMorphTo()
	{
		$class = DestinationModel::class;
		$col = 'id';

		if ($this->checkMode('flight')) {
			$class = AirportModel::class;
			$col = 'airport_code';
		}

		return  $this->belongsTo($class, 'origin_code', $col);
	}

	public function destinationMorphTo()
	{
		$class = DestinationModel::class;
		$col = 'id';

		if ($this->checkMode('flight')) {
			$class = AirportModel::class;
			$col = 'airport_code';
		}

		return  $this->belongsTo($class, 'destination_code', $col);
	}


	public function fusion()
	{
		return $this->morphTo();
	}


	public function fusionCount($fusionId)
	{
		return $this->where(['fusion_id' => $fusionId])->count();
	}


	public function location(Array $array)
	{
		$country = '';
		$destination = '';

		if (count($array) > 1) {
			$country = end($array);
			$destination = $array[count($array) - 2];
		}

		return $destination.', '.$country;
	}


	public function packageServices()
	{
		return $this->belongsToMany(
								'App\Models\B2bApp\PackageServiceModel', 
								'package_service_route',
								'route_id',
								'package_service_id'
							)->withTimestamps();
	}


	public function getPackageServicesFormattedAttribute()
	{
		return $this->packageServices->pluck('details');
	}


	public function flights()
	{
		return $this->packageServices
									->where('type', 'flight')
										->pluck('fusion.flight_details')
											->filter(function($item){
														if (!is_null($item)) {
															return $item;
														}
													})->values();
	}


	public function accommodations()
	{
		return $this->packageServices
									->where('type', 'accommodation')
										->pluck('fusion.accommodation_details')
											->filter(function($item){
													if (!is_null($item)) {
														return $item;
													}
												})->values();
	}

	public function activities()
	{
		return $this->packageServices
									->where('type', 'activity')
										->pluck('fusion.activity_details')
											->filter(function($item){
													if (!is_null($item)) {
														return $item;
													}
												})->values();
	}


	public function getRouteFormattedAttribute()
	{
		$result = $this->only([
			'token', 'mode', 'origin', 'origin_code', 'destination', 'destination_code', 'nights', 'start_date', 'end_date', 'is_pick_up', 'pick_up', 'pick_up_mode', 'is_drop_off', 'drop_off', 'drop_off_mode', 'is_breakfast', 'is_lunch', 'is_dinner', 'guest_details'
		]);

		if ($this->checkMode('flight')) {
			$result['package_flights'] = $this->flights();
		}

		if ($this->checkMode('activity')) {
			$result['package_activities'] = $this->activities();
		}

		if ($this->checkMode('accommodation')) {
			$result['package_accommodations'] = $this->accommodations();
		}

		return $result;
	}




	// if copying route then copy package activities too
	public function packageActivities()
	{
		$activities = $this->hasMany(
											'App\Models\B2bApp\PackageActivityModel', 
											'route_id'
										);
		return $activities->byIsActive();
	}


	public function package()
	{
		return $this->belongsTo('App\Models\B2bApp\PackageModel', 'package_id');
	}


	public function packageAccommodations()
	{
		$model = 'App\Models\B2bApp\PackageHotelModel';

		if ($this->mode == 'cruise') {
			$model = 'App\Models\B2bApp\PackageCruiseModel';
		}

		return $this->hasMany($model, 'route_id');
	}



	public function routes()
	{
		return $this->hasMany(RouteModel::class, 'package_id', 'package_id')
									->orderBy('order');
	}


	public function roomGuests()
	{
		if (!$this->route_room_map_id) {
			$mapId = $this->package->routeRoomMap->id;
			RouteModel::where('token', $this->token)
									->update(['route_room_map_id' => $mapId]);
			$this->refresh();
		}
		return $this->hasMany(
											'App\Models\B2bApp\RoomGuestModel',
											'route_room_map_id', 'route_room_map_id'
										);
	}

	public function getGuestDetailsAttribute()
	{
		return $this->roomGuests->pluck('guest_details');
	}	


	public function routeRoomMap()
	{
		return $this->belongsTo(
											'App\Models\B2bApp\RouteRoomMapModel',
											'route_room_map_id'
										);
	}


	// this function must call on current route
	public function fixNextDates()
	{
		if (!$this->id) return false;

		$routes = $this->routes
							->where('status', '<>', 'deleted')->values();
		// dd($routes);
		$previousRoute = $this;

		foreach ($routes as $key => $route) {
			if ($key) {
				// if next is also flight the set start date and time
				$route->start_date = $previousRoute->end_date;
				$route->start_time = $previousRoute->end_time;
				if (!$route->checkMode('flight')) {
					$route->end_date = $route->end_date;
					$route->end_time = $route->end_time;
				}
				$route->save();

				if ($route->checkMode('flight') && $route->status == 'active') {
					return true;
				}
			}

			$previousRoute = $route;
		}
	}

	

	public function accomo()
	{
		$result = mydata();

		if ($this->checkMode('hotel') && $this->status != 'active') {
			$result = $this->hotelDetail();
		}
		elseif ($this->checkMode('cruise') && $this->status != 'active') {
			$result = $this->cruiseDetail();
		}
		return $result;
	}



	public function visaDetail()
	{
		$result = null;
		if ($this->checkMode('hotel') || $this->checkMode('hotel')) {
			$result = $this->destination_detail->visaDetail;
		}
		return $result;
	}


	public function summaryString($name)
	{
		$meals = [];
		$string = '';
		$last = '';

		if ($this->is_breakfast) $meals[] = 'breakfast';
		if ($this->is_lunch) $meals[] = 'lunch';
		if ($this->is_dinner) $meals[] = 'dinner';
		
		$string = implode_as_word(', ', $meals, ' and ');

		if (strlen($string)){
			$string = $name.' with '.$string;
		}
		else{
			$string = $name.' - room only';
		}

		return $string.'.';
	}

	public function accomoSummaryString()
	{
		$paxAsWord = $this->guest_details->groupBy('string_for_rooms')
								->map(function($item, $key){
											return $item->count().' '
														.str_plural('room', $item->count())
															.' with '.$key.' basis';

										})
									->values()->implode(' | ');

		return $this->summaryString(implode_as_word(', ', 
							$this->accommodations()
										->map(function($item) use ($paxAsWord){
											return $item->get('name').' ('
														.$item->get('properties', collect())
															->pluck('property_type')
																->implode(' | ').')';			
											})->toArray(), ' and '))." | ".$paxAsWord;
	}



	public function checkMode($mode)
	{
		if ($mode == $this->mode) return true;

		$modes = [
				'flight' 	 => ['flight'],
				'hotel' 	 => ['hotel', 'hotel_only'],
				'cruise' 	 => ['cruise'],
				'activity' => ['hotel', 'activity_only'],
				'accommodation' => ['hotel', 'hotel_only', 'cruise'],
			];

		if (isset($modes[$mode])) {
			return in_array($this->mode, $modes[$mode]);
		}

		return false;
	}


	protected static function boot()
	{
		parent::boot();

		static::creating(function ($model){
			$model->token = new_token(); // setting token
			$model->order = RouteModel::byPackageId($model->package_id)->count()+1;
		});
	}


}
