<?php

namespace App\Models\ActivityApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;

class ViatorActivityModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql6';
	protected $appends = [
								'vendor', 'duration_to_human', 
								'images', 'description', 'image'
							];
	protected $table = 'viator_activities';


	public function getVendorAttribute()
	{
		return 'v';
	}

	public function getDurationToHumanAttribute()
	{
		return convertInHourMin($this->duration);
	}


	public function getShortDescriptionAttibute($value)
	{
		return strip_tags($value);
	}


	public function getDescriptionAttribute()
	{
		return $this->shortDescription;
	}


	public function getImageAttribute()
	{
		return $this->thumbnailHiResURL;
	}


	public function getImagesAttribute()
	{
		return [$this->thumbnailHiResURL];
	}



	public function scopeByCode($query, $code)
	{
		return $query->where('code', $code);
	}


	public function scopeByIsActive($query, $bool = 1)
	{
		return $query->where('is_active', $bool);
	}


	public function scopeByDestination($query, $cityId)
	{
		return $query->where('primaryDestinationId', $cityId);
	}


	public function scopeBySearch($query, $title='')
	{
		// $title = implode('%', explode(' ', $title));
		// $title = implode('%', str_split(str_replace(' ', '', $title)));

		$title = wordwrap($title, 1, "%", true);
		return $query->where("title", 'like', '%'.$title.'%');
	}


	public function findByCode($code)
	{
		$columns  = [
				'id', 'code', 'primaryDestinationId as  destinationCode', 
				'currencyCode as currency', 'title as name', 
				'shortDescription as description',  
				'rank', 'thumbnailURL as image'
			];

		return $this->select($columns)->byCode($code)->first();
	}


	public function findByDestination($cityId, $name = '')
	{
		return $this->byIsActive()->byDestination($cityId)
									->bySearch($name)->take(20)->get();
	}

}
