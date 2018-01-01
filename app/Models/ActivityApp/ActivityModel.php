<?php

namespace App\Models\ActivityApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommonApp\DestinationModel;
use App\Models\CommonApp\ImageModel;
use App\Traits\CallTrait;
use DB;

class ActivityModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql6';
	protected $table = 'activities';
	protected $appends = ['vendor', 'duration_to_human'];


	public function getVendorAttribute()
	{
		return 'f';
	}

	public function getNameAttribute($value)
	{
		return str_replace(['(', ')'], ['',''], $value);
	}

	public function getImageUrlAttribute()
	{
		return isset($this->images[0]->url) 
					 ? $this->images[0]->url 
					 : urlDefaultImageActivity();
	}

	public function getDurationToHumanAttribute()
	{
		return convertInHourMin($this->duration);
	}
	
	public function images()
	{
    return $this->morphMany(ImageModel::class, 'connectable');
	}


	public function destination()
	{
		return $this->belongsTo(DestinationModel::class, 'destination_code');
	}


	public function scopebyIsActive($query, $bool = 1)
	{
		return $query->where("is_active", $bool);
	}


	public function scopeSearchQuery($query, $name)
	{
		return $query->where('name', 'like', '%'.$name.'%');
	}


	public function scopeByDestinationCode($query, $code)
	{
		return $query->where("destination_code", $code);
	}


	public function findByDestination($code, $name = null)
	{
		return $this->byDestinationCode($code)
									->byIsActive(1)->searchQuery($name)
										->skip(0)->take(20)->get();
	}


	public function allByUnionPage($params)
	{

		$fgfActivity = DB::connection('mysql2')->table('activities')
									->select([
												'id', DB::raw('\'f\' as vendor'), 
												'destinationCode', 'currency', 'name', 
												'description', 'status', 'rank'
											])
										->where(['destinationCode' => $params->fgfDestinationCode]);


		$finalActivities = DB::connection('mysql2')->table('viator_activities')
											->select([
															'id', DB::raw('\'v\' as vendor'), 
															'primaryDestinationId as  destinationCode', 
															'currencyCode as currency', 
															'title as name', 
															'shortDescription as  description', 
															'status', 'rank'
														])
													->where(['primaryDestinationId' => $params->viatorDestinationCode])
														->unionAll($fgfActivity)
															->orderBy('rank', 'desc')
																	->simplePaginate(25);
																			// ->get();
		// dd($finalActivities);
		return $finalActivities;
	}


	/*
	| this function is to get activities from self db or cache data 
	| which is stored from other api like viator 
	| params = ["fgf_city_id" => 15180, "viator_city_id" => 10];
	*/	
	public function unionActivities($params)
	{
		$auth = auth()->user();

		$fgfCityId = $params['fgf_city_id'];
		$viatorCityId = $params['viator_city_id'];

		$viatorActivities = DB::connection('mysql2')->table('viator_activities')
												->select([
																'viator_activities.id', 'code', DB::raw('\'v\' as vendor'), 
																'primaryDestinationId as  destinationCode', 
																'currencyCode as currency', 
																'title as name', 
																'shortDescription as  description', 
																'status', 'rank', 'thumbnailURL as image'
															])
															->where(['primaryDestinationId' => $viatorCityId]);

		$agentActivities = DB::connection('mysql2')->table('agent_activities')
												->select([
																'agent_activities.id', DB::raw('CONCAT(\'OWN\', agent_activities.id) AS code, \'OWN\' as vendor'), 
																'destination_code as  destinationCode', 
																DB::raw('\'INR\' as currency'), 
																'title as name', 'description', 
																'status', DB::raw('\'0\' as rank'),
																DB::raw('CONCAT(\''.urlImage().'\', image_path) as image')
															])
															->where([
																		'admin_id' => $auth->admin->id,
																		'destination_code' => $fgfCityId
																	]);

		$finalActivities = DB::connection('mysql2')->table('activities')
											->select([
															'activities.id', DB::raw('CONCAT(prefix, activities.id) AS code, \'f\' as vendor'), 
															'destinationCode', 'currency', 'name', 
															'description', 'activities.status', 'rank',
															DB::raw(
																'(select CONCAT(\''.urlImage().'\', imagePath) 
																	from images 
																	where relationId = CONCAT(activities.prefix, activities.id)  
																	order by id asc limit 1) as image'
															)
														])
													->where(['destinationCode' => $fgfCityId])
														->unionAll($viatorActivities)
															->unionAll($agentActivities)
																->orderBy('rank', 'desc')
																	->offset(0)
                										->limit(50)
																			->get();
		return $finalActivities;
	}


	public function searchActivitiesByName($params, $index = 0, $take = 10)
	{

		$auth = auth()->user();
		$name = $params['name'];
		$fgfCityId = $params['fgf_city_id'];
		$viatorCityId = $params['viator_city_id'];

		$viatorActivities = DB::connection('mysql2')->table('viator_activities')
												->select(['title as name', 'rank'])
													->where([
															'primaryDestinationId' => $viatorCityId,
															['title', 'like', '%'.$name.'%']
														]);

		$agentActivities = DB::connection('mysql2')->table('agent_activities')
												->select(['title as name', DB::raw('\'0\' as rank')])
													->where([
																'admin_id' => $auth->admin->id,
																'destination_code' => $fgfCityId,
																['title', 'like', '%'.$name.'%']
															]);

		$finalActivities = DB::connection('mysql2')->table('activities')
											->select(['name', 'rank'])
													->where([
															'destinationCode' => $fgfCityId,
															['name', 'like', '%'.$name.'%']
														])
														->unionAll($viatorActivities)
															->unionAll($agentActivities)
																->orderBy('rank', 'desc')
																	->skip($index*$take)
																		->take($take)
																			->get();

		return $finalActivities;
	}


	public function searchActivityByName($params, $index = 0, $take = 10)
	{

		$auth = auth()->user();
		$activityNames = [];
		$name = $params['name'];
		$fgfCityId = $params['fgf_city_id'];
		$viatorCityId = $params['viator_city_id'];

		$viatorActivities = DB::connection('mysql2')->table('viator_activities')
												->select([
																'viator_activities.id', 'code', DB::raw('\'v\' as vendor'), 
																'primaryDestinationId as  destinationCode', 
																'currencyCode as currency', 
																'title as name', 
																'shortDescription as  description', 
																'status', 'rank', 'thumbnailURL as image'
															])
													->where([
															'primaryDestinationId' => $viatorCityId,
															'title' => $name
														]);

		$agentActivities = DB::connection('mysql2')->table('agent_activities')
												->select([
																'agent_activities.id', DB::raw('CONCAT(\'OWN\', agent_activities.id) AS code, \'OWN\' as vendor'), 
																'destination_code as  destinationCode', 
																DB::raw('\'INR\' as currency'), 
																'title as name', 'description', 
																'status', DB::raw('\'0\' as rank'),
																DB::raw('CONCAT(\''.urlImage().'\', image_path) as image')
															])
													->where([
																'admin_id' => $auth->admin->id,
																'destination_code' => $fgfCityId,
																'title' => $name
															]);

		$finalActivities = DB::connection('mysql2')->table('activities')
											->select([
															'activities.id', DB::raw('CONCAT(prefix, activities.id) AS code, \'f\' as vendor'), 
															'destinationCode', 'currency', 'name', 
															'description', 'activities.status', 'rank',
															DB::raw(
																'(select CONCAT(\''.urlImage().'\', imagePath) 
																	from images 
																	where relationId = CONCAT(activities.prefix, activities.id)  
																	order by id asc limit 1) as image'
															)
														])
													->where([
															'destinationCode' => $fgfCityId,
															'name' => $name
														])
														->unionAll($viatorActivities)
															->unionAll($agentActivities)
																->orderBy('rank', 'desc')
																	->skip($index*$take)
																		->take($take)
																			->get();
		
		return $finalActivities;
	}


	/*
	| code is the index(id) of this table
	*/
	public function findByCode($id)
	{
		$columns = [
				'id', 'id as code', 
				'destinationCode', 'currency', 'name', 
				'description', 'status', 'rank',
				DB::raw('(select CONCAT(\''.urlImage().'\', imagePath) 
					from images 
					where relationId = CONCAT(activities.prefix, activities.id)
					limit 1) as image'
				)
			];

		return $this->select($columns)->where(['id' => $id])->first();
	}


}
