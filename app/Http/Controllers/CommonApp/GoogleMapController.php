<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\CallTrait;

class GoogleMapController extends Controller
{
	use CallTrait;

	public $key = '';

	// this function is to get geo location
	public function geoCode($city){

		$encodeCity = str_replace (" ", "+", $city);
	  
	  $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$encodeCity."&sensor=false";

	  $geoloc = $this->httpGet($url);
	  return json_decode($geoloc);
	}

	// this function is to http get request
	public function httpGet($url){
		$ch = curl_init();  

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output = curl_exec($ch);

		curl_close($ch);
		return $output;
	}

	

	public function __construct()
	{
		$this->key = env('GOOGLE_KEY');
	}


}
