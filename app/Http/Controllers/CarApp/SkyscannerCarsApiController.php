<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\SkyscannerCarsApiController;
use App\Models\Api\SkyscannerCarModel;
use App\Traits\CallTrait;

ini_set('max_execution_time', 120);


class SkyscannerCarsApiController extends Controller
{
	use CallTrait;

	private $apiKey = '';


	public function cars($request = [])
	{
		//get country code and this can be used in market
		$location = explode(', ', $request->start_place);
		$country = CountryController::call()->getCountry(end($location));

		if (isset($request->market)) {
			$market = $request->market;
		}
		else{
			$market = isset($country->fgf_countrycode) ? $country->fgf_countrycode : 'US';
		}

		$params = (object)[
				"market" => $market,
				"currency" => "INR",
				"locale" => "en-".$market,
				"pickup_place" => round($request->start_latitude, 2).','.round($request->start_longitude, 2)."-latlong",
				"dropoff_place" => round($request->end_latitude, 2).','.round($request->end_longitude, 2)."-latlong",
				"pickup_date_time" => date_formatter($request->start_date,'d/m/Y')."T10:00",
				"drop_off_date_time" => date_formatter($request->end_date,'d/m/Y')."T10:00",
				"driver_age" => "21",
				"userip" => $_SERVER['REMOTE_ADDR']
			];


		$result = $this->getCars($params);
		$result = json_decode($result);
		
		if (isset($result->cars)) {
			$result = $this->fixImage($result);
		}

		$skyscannerCarsModel = new SkyscannerCarModel;
		$skyscannerCarsModel->request = $params;
		$skyscannerCarsModel->result = $result;
		$skyscannerCarsModel->save();

		if (!is_object($result)) {
			$result = (object)[];
		}

		$result->db = (object)["id" => $skyscannerCarsModel->id, "table" => "skyscanner_cars"];

		return $result;
	}


	/*
	| this function is to connect image url into the result
	*/
	public function fixImage($skyscannerCars)
	{
		
		$images = [];

		foreach ($skyscannerCars->images as $image) {
			$images[$image->id] = $image->url;  
		}

		$skyscannerCars->formatted_images = $images;

		foreach ($skyscannerCars->cars as &$car) {
			$car->image_url = ifset($images[$car->image_id], $images[0]);
		}

		return $skyscannerCars;
	}




	/*
	| this function is to get all cars detail
	*/
	public function getCars($params=[])
	{
		$url = "http://partners.api.skyscanner.net/apiservices/carhire/liveprices/v2/".$params->market."/".$params->currency."/".$params->locale."/".$params->pickup_place."/".$params->dropoff_place."/".$params->pickup_date_time."/".$params->drop_off_date_time."/".$params->driver_age."?apiKey=".$this->apiKey."&userip=".$params->userip;

		return $this->httpGet($url);
	}
	


	public function test()
	{
		$result = SkyscannerCarModel::find(17);
		$result->selected_index = 4;
		$result->save();

		return $result;
	}



	// this function send http get request
	public function httpGet($url){
		$ch = curl_init();  

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"GET");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

		curl_setopt($ch, CURLOPT_HTTPHEADER,[
				'Content-Type: application/x-www-form-urlencoded', 
				'Accept: application/json'
			]);

		$output = curl_exec($ch);

		curl_close($ch);
		return $output;
	}


	public function __construct()
	{
		$this->apiKey = env('SKYSCANNER_API_KEY');
	}
	
}
