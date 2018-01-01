<?php

namespace App\Models\CruiseApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;
use DB;

class CruiseOnlyDateModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql5';
	protected $table = 'cruise_only_dates';
	protected $appends = ['vendor'];
	protected $hidden = ['created_at', 'updated_at'];
	public $params = [];


	public function getVendorAttribute()
	{
		return 'f';
	}


	public function cruises(Array $params)
	{
		$params = (object) $params;
		$params->name = isset($params->name) && !is_null($params->name) 
									? $params->name
									: '';
		$where = [];
		if (isset($params->code)) {
			$where['id'] = $params->code;
		}
		elseif (isset($params->date)) {
			$where['date'] = $params->date;
		}

		$cruises = $this->where($where)
					->with('cruiseNights', 'cruiseNights.vendorDetail')
						->whereHas('cruiseNights', function($q) use ($params) {
									$q->where('nights','=', $params->nights)
										->whereHas('vendorDetail', function($q) use ($params) {
												$q->where([
														'destination_code' => $params->cityId,
														['company_name', 'like', '%'.$params->name.'%']
													]);
											});
								})
							->skip(0)
								->take(25)
									->get();
		return $cruises;
	}


	public function cruiseFormatted(Array $params)
	{
		$cruises = $this->cruises($params);
		$result = [];
		foreach ($cruises as $cruise) {
			if (isset($cruise->cruiseNights->vendorDetail->company_name)) {
				$vendorDetail = $cruise->cruiseNights->vendorDetail;
				$images = $vendorDetail->imagesAsArray();
				$image = $images[0];
				$data = [
						"id" => $cruise->id, // this is cruise_only_dates -> id 
						"name" => $vendorDetail->company_name,
						"city" => $vendorDetail->destination->destination,
						"image"	=> $image,
						"vendor" => $cruise->vendor,
						"address"	=> $vendorDetail->address,
						"country"	=> $vendorDetail->destination->country,
						"latitude" =>	$vendorDetail->latitude,
						"longitude" => $vendorDetail->longitude,
						"description" => $vendorDetail->description,
						"star_rating" => $vendorDetail->star_rating,
					];

				if (isset($params['attributes'])) {
					if (in_array('images', $params['attributes'])) {
						$data['images'] = $images;
					}
					if (in_array('itinerary', $params['attributes'])) {
						$data['itinerary'] = $this->itinerary;
					}
				}
				$result[] = (object)$data;
			}
		}
		return $result;
	}


	public function cruiseCabinsWithImages($id)
	{
		$cruise = $this->find($id);
		$images = [urlDefaultImageCruise()];
		$cabinsResult = [];
		if (isset($cruise->cruiseNights->vendorDetail) && !is_null($cruise->cruiseNights->vendorDetail)) {
			$images = $cruise->cruiseNights->vendorDetail->imagesAsArray();
			$cabinsResult = $cruise->cruiseNights->vendorDetail->cabins;
		}

		$cabins = [];
		$count = 0;
		foreach ($cabinsResult as $cabinKey => $cabin) {
			if ($cabinKey == count($images)) $count = 0;
			$image = $images[$count];
			$cabins[] = [
					"id" => $cabin->id,
					"vdr" => $cabin->vendor,
					"image" => $image,
					"cabintype" => $cabin->cabintype,
				];
			$count++;
		}
		return ["cabins" => $cabins, "images" => $images];
	}


	public function cruiseNights()
	{
		return $this->belongsTo(
											'App\Models\CruiseApp\CruiseNightModel', 
											'cruise_night_id'
										);
	}


	public function itinerary()
	{
		return $this->hasMany(
											'App\Models\CruiseApp\CruiseItineraryModel', 
											'cruise_night_id', 'cruise_night_id'
										);
	}

}
