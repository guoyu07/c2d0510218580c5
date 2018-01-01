<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Stevenmaguire\Uber\Client;

/*use Pest;
use Uber\API\OAuth;
use Uber\API\Client as BClient;*/

class UberControllerOld extends Controller
{

	public $access_token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZXMiOlsicHJvZmlsZSIsImhpc3RvcnkiXSwic3ViIjoiZWRmMmIzOTgtYWM5Mi00MWJkLWI5OWItOTA1NDM5NzU2ZjMxIiwiaXNzIjoidWJlci11czEiLCJqdGkiOiJkYTRlY2EwOC0xNmI5LTQ4MDMtYWMwMi0wNDU4MGQ5MmRkMjMiLCJleHAiOjE0ODMxODM1ODksImlhdCI6MTQ4MDU5MTU4OSwidWFjdCI6IkFZekxnNW5od0I4aElZR2JZMEVrVk80aVliTDhNcyIsIm5iZiI6MTQ4MDU5MTQ5OSwiYXVkIjoiNmNYTDhMeHBVblpjM21DZTZ0SFJmR2phT1RSZWx3bGsifQ.dgHFhytpjyFFvrtT_xFy1Ov_3IrXIfwY37DuAyXK2LR32-AXLlRYf4p3_H2hRNiH3uVLabk_lTfu8Jmtb3IKu5HMXTGsBBr3dqcWjE2mpGrwxzRefHFrMLyTPUCMdIycwwmylGfSwP4hAuoh3iBkdxA3a8apO6oqHdBgKKkMcRI87Zqbm-G7QaD3q7dbjBjbEazskjq1ZM9Fl9jtEAEu3hbGyY2OHz2jHpSI9j5V78xGPgwvAZnxe8Fkkn45jzNzGSdYWjuP_1aofUwn2FFrF32V_IVhGSo5zix5TT17Peh3148wKfzX8Suj30iAGc-nsZ0ULSW_kUgL7WNKzM3AZQ';


    public function getUber(){

    	

    	$client = new Client(array(
		    'access_token' => $this->access_token,
		    'server_token' => '7ob__ZMtgBJmfFMUKCt1lxEzFEVtkx83bcWF2teH',
		    'use_sandbox'  => true, // optional, default false
		    'version'      => 'v1', // optional, default 'v1'
		    'locale'       => 'en_US', // optional, default 'en_US'
			));

			$products = $client->getProducts(array(
				'latitude' => '41.85582993',
				'longitude' => '-87.62730337'
			));

			pre_echo($products);
    }



    public function getProductsTest()
    {
    	$access_token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZXMiOlsicHJvZmlsZSIsImhpc3RvcnkiXSwic3ViIjoiZWRmMmIzOTgtYWM5Mi00MWJkLWI5OWItOTA1NDM5NzU2ZjMxIiwiaXNzIjoidWJlci11czEiLCJqdGkiOiJkYTRlY2EwOC0xNmI5LTQ4MDMtYWMwMi0wNDU4MGQ5MmRkMjMiLCJleHAiOjE0ODMxODM1ODksImlhdCI6MTQ4MDU5MTU4OSwidWFjdCI6IkFZekxnNW5od0I4aElZR2JZMEVrVk80aVliTDhNcyIsIm5iZiI6MTQ4MDU5MTQ5OSwiYXVkIjoiNmNYTDhMeHBVblpjM21DZTZ0SFJmR2phT1RSZWx3bGsifQ.dgHFhytpjyFFvrtT_xFy1Ov_3IrXIfwY37DuAyXK2LR32-AXLlRYf4p3_H2hRNiH3uVLabk_lTfu8Jmtb3IKu5HMXTGsBBr3dqcWjE2mpGrwxzRefHFrMLyTPUCMdIycwwmylGfSwP4hAuoh3iBkdxA3a8apO6oqHdBgKKkMcRI87Zqbm-G7QaD3q7dbjBjbEazskjq1ZM9Fl9jtEAEu3hbGyY2OHz2jHpSI9j5V78xGPgwvAZnxe8Fkkn45jzNzGSdYWjuP_1aofUwn2FFrF32V_IVhGSo5zix5TT17Peh3148wKfzX8Suj30iAGc-nsZ0ULSW_kUgL7WNKzM3AZQ';

    	// $result = Socialite::with('uber')->stateless()->user();

    	// $user = Socialite::driver('uber')->user();
	  	// dd($user);
	  	// $field = json_encode($data);
			
			// //open connection
			// $ch = curl_init();
			
			// //set the url, number of POST vars, POST data
			// curl_setopt($ch,CURLOPT_URL,$url);
			// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			// curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
			// curl_setopt($ch,CURLOPT_POSTFIELDS,$field);
			// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length:'.strlen($field)));
			
			// //execute post
			// curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,60);
			// $result = curl_exec($ch);

			// //close connection
			// curl_close($ch);
			// //echo "function";




			// $curl = curl_init();

			// curl_setopt_array($curl, array(
			//   CURLOPT_URL => "https://api.uber.com/v1.2/products?latitude=37.7752315&longitude=-122.418075",
			//   CURLOPT_RETURNTRANSFER => true,
			//   CURLOPT_ENCODING => "",
			//   CURLOPT_MAXREDIRS => 10,
			//   CURLOPT_TIMEOUT => 30,
			//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			//   CURLOPT_CUSTOMREQUEST => "GET",
			//   CURLOPT_HTTPHEADER => array(
			//     "accept-language: en_US",
			//     "authorization: Bearer $access_token",
			//     "cache-control: no-cache",
			//     "content-type: application/json",
			//   ),
			// ));

			// $response = curl_exec($curl);
			// $err = curl_error($curl);

			// curl_close($curl);

			// if ($err) {
			//   echo "cURL Error #:" . $err;
			// } else {
			//   echo $response;
			// }

			// dd();

			$ch = curl_init();
			
			curl_setopt_array( $ch, array(
					CURLOPT_URL => 'https://api.uber.com/v1.2/products?latitude=37.7752315&longitude=-122.418075', 
			    CURLOPT_CUSTOMREQUEST => "GET",
			    CURLOPT_HTTPHEADER => array(
			    		'Accept-Language: en_US',
			        'Content-Type: application/json',
			        'Authorization: Bearer '.$access_token      //Need to set $accessToken
			    ),
			    CURLOPT_RETURNTRANSFER => true
			));

			$result = curl_exec( $ch );   //Make it all happen and store response

			pre_echo(json_decode($result));

    }


    public function auth($value='')
    {
    	try {
			    $options = array(
			        'clientId'     => env('UBER_KEY'), 
			        'clientSecret' => env('UBER_SECRET'),
			        'redirectUri'  => 'https://b2b.flygoldfinch.dev/dashboard/uber/auth'
			    );

			    $oauth = new OAuth($options);
			    $oauth->setScopes(array('profile','history'));


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

    public function auth1()
    {

    	$url = 'https://login.uber.com/oauth/v2/token';
			$params = [
					"client_secret" => env('UBER_SECRET'),
					"client_id" => env('UBER_KEY'),
					"grant_type" => "8cpozpKc9f7vQiALmep8XDpdesJon9",
					"redirect_uri" => 'https://b2b.flygoldfinch.dev/dashboard/uber/auth',
					"code" => "AUTHORIZATION_CODE_FROM_STEP_2"
				];

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
			$data = curl_exec($ch);
			curl_close($ch);
    	var_dump($data);
    }


    public function basvandorstUber($value='')
    {
    	$token = '7ob__ZMtgBJmfFMUKCt1lxEzFEVtkx83bcWF2teH';

    	try {
			    $adapter = new Pest('https://api.uber.com/');

			    $client = new BClient($adapter, $token, false); // define SERVER token here
			    $client->setLocale('nl_NL');

			    $products = $client->products(38.9059540,-77.0419260);
			    pre_echo($products);

			    $estimatesPrice = $client->estimatesPrice(38.9059540,-77.0419260,37.9059540,-76.0419260);
			    pre_echo($estimatesPrice);

			    $estimatesTime = $client->estimatesTime(38.9059540,-77.0419260,37.9059540,-76.0419260);
			    pre_echo($estimatesTime);

			    // $getHeaders = $client->call()->getHeaders();
			    // pre_echo($getHeaders);

			} catch(Exception $e) {
			    print $e->getMessage();
			}
    }


    public function getAccessToken($value='')
    {
    	# code...
    }

}
