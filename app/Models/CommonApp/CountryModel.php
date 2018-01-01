<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommonApp\IndicationModel;
use App\Models\CommonApp\ImageModel;


class CountryModel extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'countries';

  public function status()
	{   
		return $this->belongsTo(IndicationModel::class, 'is_active');
	}


	public function images()
	{
    $images = $this->morphMany(ImageModel::class, 'connectable');
		return $images->where('is_active', 1);
	}

	
  public function getCountry($search){

		$result = $this::select()
						->whereRaw("`country` LIKE '%$search%'")
						->first();

		return  $result;
	}

	public function getCountries($search){

		$result = $this->select()
						->whereRaw("`country` LIKE '%$search%'")
						->get();

		return  $result;
	}



}
