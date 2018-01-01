<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UberTokenController;
use Stevenmaguire\Uber\Client;
use App\Models\B2bApp\UberCabModel;
use App\Traits\CallTrait;



class UberApiController extends Controller
{
	use CallTrait;

	private $header = [];
	private $client = '';
	private $version = 'v1';
	private $accessToken = '';
	private $serverToken = '';
	private $useSandbox = false;
	private $uberTokenController = '';


	public function getAccessToken()
	{
		$tokenObj = $this->uberTokenController->fatchToken();
		
		if (strtotime("now") <= strtotime($tokenObj->refresh_before)) {
			// returning token here
			return $tokenObj->access_token;
		}
		else{
			// refreashing token here
			if ($this->refreashAccessToken($tokenObj->refresh_token)) {
				// return this function here
				return $this->getAccessToken();
			}
		}
	}

	public function getToken($code = '')
	{
		$code  = 'KEv5pt1bMrqzAEAG6Jqb9oO07Kigpt';

		$url = 'https://login.uber.com/oauth/v2/token';

		$params = [
				"client_secret" => env('UBER_SECRET'),
				"client_id" => env('UBER_KEY'),
				"grant_type" => 'authorization_code',
				"redirect_uri" => 'https://b2b.flygoldfinch.dev/dashboard/uber/auth',
				"code" => $code
			];

		$result = $this->post($url, $params);
		pre_echo(json_decode($result));

	}


	public function refreashAccessToken($refreshToken)
	{


		$url = 'https://login.uber.com/oauth/v2/token';

		$params = [
				"client_secret" => env('UBER_SECRET'),
				"client_id" => env('UBER_KEY'),
				"grant_type" => 'refresh_token',
				"redirect_uri" => 'https://b2b.flygoldfinch.dev/dashboard/uber/auth',
				"refresh_token" => $refreshToken
			];

		$data = $this->post($url, $params);

		$data = json_decode($data);
		
		$expiresIn = secToDay($data->expires_in)-5;
		$refreshBefore = addDaysinDate(date("Y-m-d h:i:s"), $expiresIn, "Y-m-d h:i:s");

		$storeParams = (object)[
				"scope" => $data->scope,
				"token_type"  => $data->token_type,
				"expires_in"  => $data->expires_in,
				"access_token"  => $data->access_token,
				"refresh_token"  => $data->refresh_token,
				"refresh_before"  => $refreshBefore,
				"last_authenticated"  => $data->last_authenticated,
			];

		return $this->uberTokenController->storeToken($storeParams);
	}


	/*
	| 
	*/
	public function getProduct($params)
	{
		$products = $this->client->getProducts([
				'latitude' => $params->start_latitude,
				'longitude' => $params->start_longitude
			]);

		$productsTemp = [];

		foreach ($products->products as $product) {
			$productsTemp[$product->product_id] = $product;
		}

		$estimates = $this->client->getPriceEstimates(array(
				'start_latitude' => $params->start_latitude,
				'start_longitude' => $params->start_longitude,
				'end_latitude' => $params->end_latitude,
				'end_longitude' => $params->end_longitude,
			));

		foreach ($estimates->prices as &$estimate) {
			$estimate->product = $productsTemp[$estimate->product_id];
		}

		$payment_method = json_decode($this->getPaymentMethods());
		if (isset($payment_method->payment_methods)) {
			$paymentMethodTemp = [];
			foreach ($payment_method->payment_methods as $paymentMethod) {
				$paymentMethodTemp[$paymentMethod->type] = $paymentMethod;
			}
			$payment_method->edit = rejson_decode(['payment_method' => $paymentMethodTemp]);
		}

		$estimates->payment_method = $payment_method;
		// storing data in db in table 'uber_cabs'
		$uberCab = new UberCabModel;
		$uberCab->start_latitude = $params->start_latitude;
		$uberCab->start_longitude = $params->start_longitude;
		$uberCab->end_latitude = $params->end_latitude;
		$uberCab->end_longitude = $params->end_longitude;
		$uberCab->seat_count = $params->seat_count;
		$uberCab->estimates = json_encode($estimates);
		$uberCab->save();

		$estimates->dbId = $uberCab->id;

		return $estimates;
		
	}

	public function getPaymentMethods()
	{
		return $this->get($this->getUrlFromPath('payment-methods'), null, $this->header);
	}

	public function book($request)
	{
		$uberCab = UberCabModel::find($request->rowIndex);

		$estimates = json_decode($uberCab->estimates);
		$paymentMethodId = isset($estimates->payment_method
												->edit->payment_method->cash->payment_method_id) 
												? $estimates->payment_method
												->edit->payment_method->cash->payment_method_id
												: '7aa8ea7a-146e-486b-9e46-48a023a178a7';

		$requestEstimates = json_decode($uberCab->requests_estimate);

		$params = [
				'fare_id' => $requestEstimates->response->fare->fare_id,
				'product_id' => $requestEstimates->request->product_id, // Optional
				'payment_method_id' => $paymentMethodId,
				'start_latitude' => $uberCab->start_latitude,
				'start_longitude' => $uberCab->start_longitude,
				'end_latitude' => $uberCab->end_latitude,
				'end_longitude' => $uberCab->end_longitude,
				'seat_count' => $uberCab->seat_count
			];

		$rideRequest = $this->postRequestRide($params);
		$driver =  $this->getCurrentRequest();

		$result = (object)[
			"request" => $params,
			"rideRequest" => $rideRequest,
			"driver" => $driver,
		];

		$uberCab->ride_request = json_encode($rideRequest);
		$uberCab->requests_current = json_encode($driver);
		$uberCab->book = json_encode($result);
		$uberCab->save();

		return rejson_decode($result);

		// return CabsController::call()->createNew((object)[
		// 		"relation_id" => $request->rowIndex,
		// 		"relation_table" => 'uber_cabs' 
		// 	]);
	}


	/*
	| $params = [
	|			'start_latitude' => 28.66866719999999,
	|			'start_longitude' => 77.10194000000001,
	|			'end_latitude' => 28.6314512,
	|			'end_longitude' => 77.21666720000007,
	|			'product_id' => 'c8170d76-b67c-44b1-8c26-5f45541434d2', // Optional
	|			'seat_count' => 2 // this must be define if (uberPool) Default and maximum value is 2.
	|		];
	*/
	public function postRequestEstimate($request)
	{
		$uberCab = UberCabModel::find($request->rowIndex);

		$estimates = json_decode($uberCab->estimates);

		$params = [
				'start_latitude' => $uberCab->start_latitude,
				'start_longitude' => $uberCab->start_longitude,
				'end_latitude' => $uberCab->end_latitude,
				'end_longitude' => $uberCab->end_longitude,
				'product_id' => $estimates->prices[$request->index]->product_id, // Optional
			];

		// if uberPool then setting seat count here
		if ($estimates->prices[$request->index]->display_name == 'uberPool') {
			$params['seat_count'] = $uberCab->seat_count;
		}

		$url = $this->getUrlFromPath('requests/estimate');
		$response = $this->post($url, json_encode($params), $this->header);
		$response = json_decode($response);

		if (isset($response->fare)) {
			$response->price = $response->fare->display;
			$response->currency_code = $response->fare->currency_code;
		}elseif (isset($response->estimate)) {
			$response->price = $response->estimate->display;
			$response->currency_code = $response->estimate->currency_code;
		}

		$result = [
			"request" => $params,
			"response" => $response,
		]; 
		
		$uberCab->requests_estimate = json_encode($result);
		$uberCab->save();

		return rejson_decode($result);
	}

	public function postRequestRide($params)
	{
		$url = $this->getUrlFromPath('requests');
		$response = $this->post($url, json_encode($params), $this->header);
		return json_decode($response);
	}

	public function getCurrentRequest()
	{
		$url = $this->getUrlFromPath('requests/current');
		$response = $this->get($url, null, $this->header);
		return json_decode($response);
	}


	/*
	| this is for defining is url in sandbox or live
	*/
	public function getUrlFromPath($path)
	{
		$path = ltrim($path, '/');
		$isSandBox = $this->useSandbox ? 'sandbox-' : '';
		return 'https://'.$isSandBox.'api.uber.com/'.$this->version.'/'.$path;
	}

	

	/*
	| executing curl here
	*/

	public function post($url, $data = null,  $header = [])
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);     
		$result = curl_exec($ch);
		
		return $result;
	}

	public function get($url, $data = null, $header = [])
	{
		$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);     
 
		$output = curl_exec($ch);
 
		curl_close($ch);
		return $output;
	}

	public function auth()
	{
		try {
				$options = array(
						'clientId'     => env('UBER_KEY'), 
						'clientSecret' => env('UBER_SECRET'),
						'redirectUri'  => 'https://b2b.flygoldfinch.dev/dashboard/uber/auth'
				);

				$oauth = new \Uber\API\OAuth($options);
				$oauth->setScopes(array('profile','history', 'history_lite', 'request'));


				if (!isset($_GET['code'])) {
					 print '<a href="'.$oauth->getAuthorizationUrl().'">connect</a>';
				} 
				else {

					echo $_GET['code'];
					echo '<br/>';

					$url = 'https://login.uber.com/oauth/v2/token';

					$params = [
							"client_secret" => env('UBER_SECRET'),
							"client_id" => env('UBER_KEY'),
							"grant_type" => 'authorization_code',
							"redirect_uri" => 'https://b2b.flygoldfinch.dev/dashboard/uber/auth',
							"code" => "TfOsknMjS4V86bqQwuytQKUJvh5ejK"
						];

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
					$data = curl_exec($ch);
					curl_close($ch);
					pre_echo(json_decode($data));
					echo '<br/>';
					exit;
					// $token = $oauth->getAccessToken('authorization_code', array(
					//     'code' => $_GET['code']
					// ));

					// echo $token;


					$params = [
							"client_secret" => env('UBER_SECRET'),
							"client_id" => env('UBER_KEY'),
							"grant_type" => 'refresh_token',
							"redirect_uri" => 'https://b2b.flygoldfinch.dev/dashboard/uber/auth',
							"refresh_token" => "Ul0MJfxtZQiNATfgFC36hnYGr9evcX"
						];

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
					$data = curl_exec($ch);
					curl_close($ch);
					pre_echo(json_decode($data));
				}
		} catch(\Exception $e) {
				print $e->getMessage();
		}
	}




	public function __construct()
	{
		// Making new object UberTokenController
		$this->uberTokenController = new UberTokenController;


		$this->version = 'v1.2';
		$this->useSandbox = true;
		$this->accessToken  = $this->getAccessToken();
		$this->serverToken = env('UBER_SERVER_TOKEN');

		$this->header = [
			"Authorization: Bearer ".$this->accessToken,
			"Content-Type: application/json"
		];
		
		// Making new client object
		$this->client = new Client([
				'access_token' => $this->accessToken,
				'server_token' => $this->serverToken,
				'use_sandbox'  => $this->useSandbox, // optional, default false
				'version'      => $this->version, // optional, default 'v1'
				'locale'       => 'en_US', // optional, default 'en_US'
			]);
	}

	// ===========================this is test function===========================

	public function testCurrentRequest()
	{
		dd($this->getCurrentRequest()); 
	}

	public function testRequestRide()
	{
		$params = [
				'start_latitude' => 28.66866719999999,
				'start_longitude' => 77.10194000000001,
				'end_latitude' => 28.6314512,
				'end_longitude' => 77.21666720000007,
				'product_id' => 'c8170d76-b67c-44b1-8c26-5f45541434d2', // Optional
				// 'surge_confirmation_id' => 'e100a670',  // Optional
				// 'payment_method_id' => 'a1111c8c-c720-46c3-8534-2fcd'   // Optional
			];


		$result = $this->post($this->getUrlFromPath('requests/estimate'), json_encode($params), $this->header);

		dd_pre_echo(json_decode($result));

		try {
			$requestEstimate = $this->client->postRequestEstimate($params);
			dd_pre_echo($requestEstimate);
			$request = $this->client->requestRide($params);
			// dd_pre_echo($request);

		} catch (Stevenmaguire\Uber\Exception $e) {
			$body = $e->getBody();
			$surgeConfirmationId = $body['meta']['surge_confirmation']['surge_confirmation_id'];
		}

	}

}
