<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;
use DB;

class AirportModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql2';
	protected $table = 'airports';
	protected $appends = ['location' ];

	public function getLocationAttribute()
	{
		$country = isset($this->attributes['country']) 
						 ? $this->attributes['country']
						 : '';

		$destination = isset($this->attributes['city']) 
						 ? $this->attributes['city']
						 : '';

		return echoLocation($destination, $country);
	}
	

	
	public function getAirport($search){

		return DB::connection('mysql2')->select(
							DB::raw("SELECT CONCAT(`airport_code`, ', ', `city`, ', ', `country`) AS `airports` FROM `airports` WHERE CONCAT(`airport_code`, ', ', `city`, ', ', `country`) LIKE '%$search%'")
				);
	}

	public function getLocation($search)
	{
		$result = DB::connection('mysql2')->select(
			DB::raw("SELECT CONCAT(a.`airport_code`, ', ', a.`airport_name`, ', ' , a.`city`, ', ', a.`country`,' | ', d.`destination`, ', ', d.`country`) AS `airports` FROM `airports` a JOIN `destinations` d ON d.`country_code` LIKE a.`country_code` AND d.`destination` LIKE a.`city` OR a.`city` LIKE d.`destination` WHERE a.`airport_code` = '$search' OR CONCAT(a.`airport_code`, ', ', a.`airport_name`, ', ', a.`city`, ', ', a.`country`) LIKE '%$search%' OR CONCAT(a.`airport_code`, ' ', a.`airport_name`, ' ', a.`city`, ' ', a.`country`) LIKE '%$search%'")
		);
		
		return $result;
	}

	/*
	| this function is return and array
	| ["Airport_Code, Airport_Name, Destination_Or_City_Name, Country_Name"]
	*/
	public function getAirportAndLocation($search)
	{
		$sqlQuery = (
			"SELECT CONCAT
			  (
			    a.`airport_code`, ', ',
			    a.`airport_name`, ', ',
			    IFNULL(d.`destination`, a.`city`),  ', ',
			    IFNULL(d.`country`, a.`country`)
			  ) AS `airports`
			FROM
			  `airports` a
			LEFT JOIN
			  `destinations` d 
			  ON d.`country_code` = a.`country_code` 
			  AND (d.`destination` LIKE a.`city` OR a.`city` LIKE d.`destination`)
			WHERE "
		);

		if (strlen($search) <= 3) {
			$sqlQuery .= "a.`airport_code` = '$search'";
		}
		else{
			$sqlQuery .= (
				"CONCAT(
			    a.`airport_code`,', ',
			    a.`airport_name`,', ',
			    a.`city`,', ',
			    a.`country`
			  ) LIKE '%$search%' 

				OR CONCAT(
				  a.`airport_code`,' ',
				  a.`airport_name`,' ',
				  a.`city`,' ',
				  a.`country`
				) LIKE '%$search%'"
			);
		}
		$sqlQuery .= 'limit 10';
		
		$result = DB::connection('mysql2')->select(DB::raw($sqlQuery));
		return $result;
	}

	public function getAirportNames($search)
	{
		$sqlQuery = (
			"SELECT CONCAT
			  (
			    a.`airport_code`, ', ',
			    a.`airport_name`, ', ',
			    IFNULL(d.`destination`, a.`city`),  ', ',
			    IFNULL(d.`country`, a.`country`)
			  ) AS `fullname`, a.`airport_code`, a.`airport_name`, 
			  IFNULL(d.`destination`, a.`city`) AS city, 
			  IFNULL(d.`country`, a.`country`) AS country
			FROM
			  `airports` a
			LEFT JOIN
			  `destinations` d 
			  ON d.`country_code` = a.`country_code` 
			  AND (d.`destination` LIKE a.`city` OR a.`city` LIKE d.`destination`)
			WHERE "
		);

		if (strlen($search) <= 3) {
			$sqlQuery .= "a.`airport_code` = '$search'";
		}
		else{
			$sqlQuery .= (
				"CONCAT(
			    a.`airport_code`,', ',
			    a.`airport_name`,', ',
			    a.`city`,', ',
			    a.`country`
			  ) LIKE '%$search%' 

				OR CONCAT(
				  a.`airport_code`,' ',
				  a.`airport_name`,' ',
				  a.`city`,' ',
				  a.`country`
				) LIKE '%$search%'"
			);
		}

		$sqlQuery .= 'limit 10';
		$result = DB::connection('mysql2')
							->select(DB::raw($sqlQuery));
		return $result;
	}

	

}
