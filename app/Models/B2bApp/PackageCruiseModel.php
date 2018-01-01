<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\CruiseApp\CruiseOnlyDateModel;
use App\Models\B2bApp\PackageCruiseCabinModel;
use App\MyLibrary\MyData;
use App\Traits\CallTrait;

class PackageCruiseModel extends Model
{
	use CallTrait;

	protected $table = 'package_cruises';
	protected $appends = ['detail'];


	public function cabinModel()
	{
		return new PackageCruiseCabinModel;
	}

	public function getCruiseIdAttribute()
	{
		return $this->cruise_code;
	}


	public function getCruiseTypeAttribute()
	{
		$model = '';
		if ($this->vendor == 'f' || is_null($this->vendor)) {
			$model = 'App\Models\CruiseApp\CruiseOnlyDateModel';
		}
		return $model;
	}


	public function cabins()
	{
		$cabins = [];
		foreach ($this->packageCabins as $cabin) {
			if (isset($cabin->cabin->cabin_code)) {
				$cabins[] = $cabin->cabin->cabin_code.'-'.$cabin->cabin->cabin;
			}
		}
		return $cabins;
	}

	public function packageCabins()
	{
		return $this->hasMany(
							'App\Models\B2bApp\PackageCruiseCabinModel', 
							'package_cruise_id'
						);
	}


	public function cruise()
	{
		return $this->morphTo();
	}


	public function images()
	{
		return isset($this->cruise->cruiseNights->vendorDetail->images)
					? $this->cruise->cruiseNights->vendorDetail->imagesAsArray()
					: [];
	}


	public function findByCode($params)
	{
		$detail = CruiseOnlyDateModel::call()->cruiseFormatted($params);
		$detail = isset($detail[0]) ? $detail[0] : $this;
		return $detail;
	}


	public function cruiseDetail($params)
	{
		$params['code'] = $this->cruise_code;
		$params['vendor'] = $this->vendor;
		$params['attributes'] = ['images', 'itinerary'];
		$detail = $this->findByCode($params);
		$result = (object)[
				"id" => $this->id,
				"code" => $detail->id,
				"vendor" => $detail->vendor,
				"name" => proper($detail->name),
				"latitude" => $detail->latitude,
				"longitude" => $detail->longitude,
				"nights" => '',
				"location" => '',
				"endDate" => '',
				"startDate" => '',
				"address" => $detail->address,
				"city" => $detail->city,
				"country" => $detail->country,
				"cabins" => $this->cabins(),
				"image" => $detail->image,
				"starRating" => $detail->star_rating,
				"starRatingHtml" => '',
				"description" => $detail->description,
				"shortDescription" => $detail->description,
				"htmlDescription" => $detail->description,
				"itinerary" => $this->cruise->itinerary,
			];

		$result->starRatingHtml = getStarImage($result->starRating, 15, 15);
		$result->shortDescription = sub_string($result->description, 120);
		return $result;
	}
}
