<?php

namespace App\Http\Controllers\FlightApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FlightApp\SkyscannerFlightsModel;
use App\Traits\CallTrait;

class SkyscannerFlightsController extends Controller
{
	use CallTrait;

	protected $key = '';


	/*
	| this function for getting flight result form SkyscannerApi 
	| using post method
	| array should be like
	| $params = [
		"apiKey" => env('SKYSCANNER_KEY'),
		"Country" => "IN",
		"Currency" => "INR",
		"Locale" => "en-IN",
		"Adults" => 1,
		"Children" => 0,
		"Infants" => 0,
		"OriginPlace" => "DEL",
		"DestinationPlace" => "SIN",
		"OutboundDate" => "YYYY-mm-dd",
		"InboundDate" => "YYYY-mm-dd",
		"LocationSchema" => "Default",
		"CabinClass" => "Economy",
		"GroupPricing" => 1
	]
	*/

	public function flights($packageFlight)
	{
		$flights = [];

		$params = [
				// "cabinclass" => "Economy",
				"country" => "US",
				"currency" => "USD",
				"locale" => "en-US",
				"locationSchema" => "iata",
				"originplace" => $packageFlight->route->origin_code,
				"destinationplace" => $packageFlight->route->destination_code,
				"outbounddate" => $packageFlight->route->start_datetime->format('Y-m-d'),
				// "inbounddate" => "2017-06-02",
				"adults" => 1,
				"children" => 0,
				"infants" => 0,
				"apikey" => $this->key
			];

		$flights = $this->postFlight($params);

		return $flights;
	}


	public function postFlight($params=[])
	{
		$url = 'http://business.skyscanner.net/apiservices/pricing/v1.0/';
		// $url = 'http://partners.api.skyscanner.net/apiservices/pricing/v1.0/';

		// creating session here
		$session = $this->createSession($url, $params);

		// polling flights here
		$flights = $this->pollSession($session->location);

		$skyscannerFlights = new SkyscannerFlightsModel;
		$skyscannerFlights->request = $session;
		$skyscannerFlights->result = $flights;
		$skyscannerFlights->save();
		$flights->Places = $skyscannerFlights->placesFormatted;
		$flights->Carriers = $skyscannerFlights->carriersFormatted;
		$flights->db = (object)['id' => $skyscannerFlights->id];
		$flights = $this->setUnsetIndex($flights);
		return $flights;
	}


	public function createSession($url, $params)
	{
		$result = $this->httpPost($url, $params);
		list($headers, $response) = explode("\r\n\r\n", $result, 2);
		// $headers now has a string of the HTTP headers
		// $response is the body of the HTTP response
		$location = '';
		$headers = explode("\n", $headers);

		foreach($headers as $header) {
			if (stripos($header, 'Location:') !== false) {
				$location = str_replace(['Location: ', "\r"], ['', ''], $header);
			}
		}

		$location = $location."?apikey=".$this->key;

		$result = (object)[
				"location" => $location,
				"response" => $response,
				"headers" => $headers
			];

		return $result;
	}


	public function pollSession($url)
	{
		$result = $this->httpGet($url.'&pageIndex=0&pageSize=1000');
		$result = json_decode($result);
		if (!is_object($result)) {
			$result = (object)["error" => "Not Found"];
		}
		return $result;
	}


	public function book($id, $index)
	{
		$flight = SkyscannerFlightsModel::find($id);
		$return = false;

		if (!is_null($flight)) {
			// this is result in json which is got from calling qpx flight api 
			$flightDetail = $flight->result;
			// putting index in selected_index column in db 
			$flight->selected_index  =  $index;
			// saving data here
			$flight->save();

			$segmentIds = $flightDetail->Legs[$index]->SegmentIds;
			$startDate = $flightDetail->Segments[$segmentIds[0]]->DepartureDateTime;
			$startDate = str_replace('T', ' ', $startDate);
			$endDate = $flightDetail->Segments[count((array)$segmentIds)-1]->ArrivalDateTime;
			$endDate = str_replace('T', ' ', $endDate);

			// this array have to be return,
			$return = (object)[
					"startDateTime" => getDateTime($startDate),
					"endDateTime" => getDateTime($endDate),
					"vendor" => 'ss',
				];
			
		}
		return $return;
	}


	public function setUnsetIndex($flights)
	{
		unset($flights->Agents);
		unset($flights->Currencies);
		unset($flights->Itineraries);
		unset($flights->Query);
		return $flights;
	}

	public function httpPost($url, $data){
	
		$httpdata = http_build_query($data);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $httpdata);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,[
				'Content-Type: application/x-www-form-urlencoded', 
				'Accept: application/json']
			);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		
		$result = curl_exec($ch);

		curl_close($ch);

		return $result;
	}



	public function httpGet($url)
	{

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		return $response;
	}



	public function httpGetOld($url){
		$ch = curl_init();  

		curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"GET");
		// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, 0);
		// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
		// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

		// curl_setopt($ch, CURLOPT_HTTPHEADER,[
		// 		'Content-Type: application/x-www-form-urlencoded', 
		// 		'Accept: application/json'
		// 	]);

		$output = curl_exec($ch);

		curl_close($ch);
		return $output;
	}

	public function __construct()
	{
		$this->key = env('SKYSCANNER_API_KEY');

	}

}
