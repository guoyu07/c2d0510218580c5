<?php

namespace App\Models\CruiseApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\HotelApp\CoordinateTrait;
use App\Models\CruiseApp\CruiseCabinModel;

class CttCruiseModel extends Model
{
	use CoordinateTrait;

	protected $connection = 'mysql5';
	protected $table = 'ctt_cruises';
	protected $casts = ['cabins_json' => 'collection'];
	protected $appends = [
				'code', 'vendor', 'city', 'address', 'built_data',
				'cabin_built_data'
			];


	public function getCodeAttribute()
	{
		return $this->id;
	}


	public function getVendorAttribute()
	{
		return 'ctt';
	}


	public function getCityAttribute()
	{
		return $this->destination;
	}


	public function getImageAttribute($value)
	{
		return 'https://www.cruisetimetables.com'.$value;
	}



	public function getAddressAttribute()
	{
		return $this->destination;
	}



	public function getDescriptionAttribute()
	{
		$cleanHtml = clean_html($this->itinerary);
		if (strlen($cleanHtml) != strlen($this->itinerary)) {
			$cleanHtml = trim(strip_tags(str_replace('<b>Cruise Schedule</b>: ', '', $cleanHtml)));
			
			CttCruiseModel::where('id', $this->id)
											->update(['itinerary' => $cleanHtml]);
		}

		return collect(explode(';', $cleanHtml))
						->map(function($item){
									return '('.trim(substr($item, 0, stripos($item, '('))).')';
								})
							->implode(' → ');
	}



	public function getBuiltDataAttribute()
	{
		return collect([
					'id' => $this->id,
					'ukey' => $this->code.'_'.$this->vendor,
					'code' => $this->code,
					'name' => $this->name,
					'city' => $this->city,
					'image' => $this->image,
					'images' => $this->images(),
					'vendor' => $this->vendor,
					'address' => $this->address,
					'country' => $this->country,
					'latitude' => $this->latitude,
					'longitude' => $this->longitude,
					'description' => $this->description,
					'star_rating' => null
				]);
	}	



	public function getCabinBuiltDataAttribute()
	{
		if (!$this->cabins->count()) {
			$this->cruiseCabinsStore();
		}

		return $this->cabins->pluck('built_data')
									->map(function($item){
												$item->put('image', $this->image);
												return $item;
											});
	}


	public function scopeBySearch($query, $name = '')
	{
		$name = '%'.wordwrap($name, 1, "%", true).'%';
		return $query->where('name', 'like', $name);
	}


	public function images()
	{
		return [$this->image];
	}



	public function cabins()
	{
		return $this->morphMany(CruiseCabinModel::class, 'cruise');
	}


	public function cruiseCabinsStore()
	{
		$find = stripos($this->cabins_json->implode(''), 'Schedule');
		if ($find != false) { return []; }

		$find = stripos($this->cabins_json->implode(''), 'From');
		if ($find != false) { return []; }

		$cabins = $this->cabins_json;
		$this->cabins_json->map(function($item, $key){
			if (strlen($item)) {
				$cabin = new CruiseCabinModel;
				$cabin->cruise_id = $this->id;
				$cabin->cruise_type = CttCruiseModel::class;
				$cabin->cabin = trim($item);
				$cabin->save();
			}
		});

		$this->refresh();
		return true;
	}


}
