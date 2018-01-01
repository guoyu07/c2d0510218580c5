<?php

namespace App\Http\Controllers\ActivityApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\CallTrait;

ini_set('max_execution_time', 7200);

// ==================================Routes Used==================================
// Route::get('dashboard/data/viator/product/detail/saved', 'Api\ViatorController@fatchProductDetailBySavedData');
// Route::get('dashboard/data/viator/product/detail/saved1', 'Api\ViatorController@fatchProductDetailBySavedData1');
// Route::get('dashboard/data/viator/product/detail/saved2', 'Api\ViatorController@fatchProductDetailBySavedData2');
// Route::get('dashboard/data/viator/product/detail/saved3', 'Api\ViatorController@fatchProductDetailBySavedData3');
// Route::get('dashboard/data/viator/product/detail/saved4', 'Api\ViatorController@fatchProductDetailBySavedData4');
// Route::get('dashboard/data/viator/product/detail/saved5', 'Api\ViatorController@fatchProductDetailBySavedData5');
// Route::get('dashboard/data/viator/product/detail/saved/{index}/{to}', 'Api\ViatorController@fatchProductDetailBySavedDataParams');


class ViatorController extends Controller
{
	use CallTrait;
	
	public $key = '2134351327133057';
	public $currencyCode = 'USD';
	public $liveUrl = 'http://viatorapi.viator.com/';
	public $preLiveUrl = 'http://prelive.viatorapi.viator.com/';
	public $isPreLive = true; 


	public function productUrl()
	{
		$domain = $this->isPreLive ? $this->preLiveUrl : $this->liveUrl;
		return $this->domain."service/search/products?apiKey=".$this->key;
	}

	public function postProduct($params)
	{
		$paramsTemp = [
				"startDate" => null,
				"endDate" => null,
				"destId" => null, 
				"currencyCode" => null, 
				"catId" => 0, 
				"subCatId" => 0, 
				"dealsOnly" => false
			];

		$params = json_encode(array_merge($paramsTemp, $params));


		$url = "http://prelive.viatorapi.viator.com/service/search/products?apiKey=$this->key";
		$result = $this->do_post_request($url,$params, "Content-Type: application/json\n");

		return $result;
	}


	public function fatchProductByDestination($value='')
	{
		$destIds = [10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 27, 28, 29, 30, 31, 32, 34, 36, 37, 38, 39, 40, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 75, 76, 77, 78, 79, 80, 722, 723, 724, 725, 727, 728, 730, 731, 732, 734, 743, 744, 745, 746, 747, 748, 749, 778, 779, 780, 781, 801, 809, 810, 814, 825, 919, 927, 948, 963, 966, 967, 972, 4131, 4141, 4146, 4214, 4308, 4311, 4316, 4321, 4324, 4393, 4425, 4439, 4444, 4448, 4452, 4458, 4461, 4463, 4471, 4475, 4479, 4492, 4497, 4499, 4514, 4528, 4583, 4603, 4616, 4672, 4733, 4770, 4772, 4774, 4776, 4782, 4786, 4788, 4830, 4868, 4917, 5026, 5069, 5157, 5202, 5212, 5308, 5411, 5438, 5575, 5589, 21470, 21472, 21767, 21768, 21770, 21797, 21800, 21802, 21805, 21806, 21891, 21900, 21901, 21903, 21908, 21911, 21912, 21916, 21936, 21940, 22158, 22165, 22232, 22314, 22315, 22316, 22417, 25958, 26731, 26852, 27539, 29094, 32314];

		$url = "http://prelive.viatorapi.viator.com/service/search/products?apiKey=$this->key";
		
		$nullArray = [];
		return 'this funtion is stoped because all data already get';
		exit;
		foreach ($destIds as $destId) {
			$data = [
					"startDate" => "2017-01-10",
					"endDate" => "2017-01-10",
					"destId" => $destId, 
					"currencyCode" => "USD", 
					"catId" => 0, 
					"subCatId" => 0, 
					"dealsOnly" => false
				];

			$data = json_encode($data);

			$result = $this->do_post_request($url,$data, "Content-Type: application/json\n");
			if ($result == null) {
				$nullArray[] = $destId;				
			}else{
				saveInFile($result, $destId, 'json', 'test/api/viator/product');
			}
		}

		echo json_encode($nullArray);
	}

	public function fatchProductDetail()
	{
		$url ="http://prelive.viatorapi.viator.com/service/product?code=23491P1&amp;currencyCode=USD&amp;excludeTourGradeAvailability=false&amp;apiKey=2134351327133057";

		return $this->httpGet($url);
	}

	public function fatchProductDetailBySavedData()
	{
		// $pulled = [10, 11, 12, 13, 14, 15, 16, 722, 723, 724, 725, 727, 728, 730, 731, 732, 734, 743, 744, 745, 746, 747, 748, 749, 778, 779, 780, 781, 801];
		$destIds = [];

		
		$found = false;

		foreach ($destIds as $destId) {
			$recoveredData = file_get_contents("test/api/viator/product/$destId.json");
			$recoveredArrays = json_decode($recoveredData);
			
			if (!file_exists("test/api/viator/product_detail/$destId")) {
				mkdir("test/api/viator/product_detail/$destId");
			}

			if (isset($recoveredArrays->data) && is_array($recoveredArrays->data)) {
				foreach ($recoveredArrays->data as $data) {
					
					if ($data->code == '9466P27') {
						$found = true;
					}
					
					
					if ($found) {
						$url = $this->preLiveUrl."service/product?code=".$data->code."&currencyCode=USD&excludeTourGradeAvailability=false&apiKey=2134351327133057";

						$url = str_replace( "&amp;", "&", urldecode(trim($url)) );
						// dd($url);
						$response = $this->httpGet($url);
						saveInFile($response, $data->code, 'json', "test/api/viator/product_detail/$destId");
					}

					
					
				}
			}
		}
	}

	public function fatchProductDetailBySavedData1()
	{
		// $destIds = [17, 18, 19, 20, 21, 809, 810, 814, 825, 919, 927, 948, 963, 966, 967, 972];
		$destIds = [];

		$found = false;

		foreach ($destIds as $destId) {
			$recoveredData = file_get_contents("test/api/viator/product/$destId.json");
			$recoveredArrays = json_decode($recoveredData);
			
			if (!file_exists("test/api/viator/product_detail/$destId")) {
				mkdir("test/api/viator/product_detail/$destId");
			}

			if (isset($recoveredArrays->data) && is_array($recoveredArrays->data)) {
				foreach ($recoveredArrays->data as $data) {
					if ($data->code == '23491P1') {
						$found = true;
					}

					if ($found) {
						$url = $this->preLiveUrl."service/product?code=".$data->code."&currencyCode=USD&excludeTourGradeAvailability=false&apiKey=2134351327133057";

						$url = str_replace( "&amp;", "&", urldecode(trim($url)) );
						// dd($url);
						$response = $this->do_get_request($url);
						saveInFile($response, $data->code, 'json', "test/api/viator/product_detail/$destId");
					}

					
				}
			}
		}
	}

	public function fatchProductDetailBySavedData2()
	{
		// $destIds = [22, 23, 24, 27, 28, 78, 79, 80, 4448, 4452, 4458, 4461, 4463, 4471, 4475, 4479, 4492, 4497, 4499, 4514, 4528, 4583, 4603];
		$destIds = [];


		$found = false;

		// $ret = @get_headers("http://prelive.viatorapi.viator.com/service/product?code=16787P3&amp;currencyCode=USD&amp;excludeTourGradeAvailability=false&amp;apiKey=2134351327133057");
		// dd($ret);

		foreach ($destIds as $destId) {
			$recoveredData = file_get_contents("test/api/viator/product/$destId.json");
			$recoveredArrays = json_decode($recoveredData);
			
			if (!file_exists("test/api/viator/product_detail/$destId")) {
				mkdir("test/api/viator/product_detail/$destId");
			}

			if (isset($recoveredArrays->data) && is_array($recoveredArrays->data)) {
				foreach ($recoveredArrays->data as $data) {
					// if ($data->code == '9218P8') {
					// 	$found = true;
					// }

					// if ($found) {
						$url = $this->preLiveUrl."service/product?code=".$data->code."&currencyCode=USD&excludeTourGradeAvailability=false&apiKey=2134351327133057";

						$url = str_replace( "&amp;", "&", urldecode(trim($url)) );
						// dd($url);
						$response = $this->httpGet($url);
						saveInFile($response, $data->code, 'json', "test/api/viator/product_detail/$destId");
					// }

					

				}
			}
		}
	}


	public function fatchProductDetailBySavedData3()
	{
		// $destIds = [75, 76, 77];
		$destIds = [];

		$found = false;

		foreach ($destIds as $destId) {
			$recoveredData = file_get_contents("test/api/viator/product/$destId.json");
			$recoveredArrays = json_decode($recoveredData);
			
			if (!file_exists("test/api/viator/product_detail/$destId")) {
				mkdir("test/api/viator/product_detail/$destId");
			}

			if (isset($recoveredArrays->data) && is_array($recoveredArrays->data)) {
				foreach ($recoveredArrays->data as $data) {
					
					
					if ($found) {
						$url = $this->preLiveUrl."service/product?code=".$data->code."&currencyCode=USD&excludeTourGradeAvailability=false&apiKey=2134351327133057";

						$url = str_replace( "&amp;", "&", urldecode(trim($url)) );
						// dd($url);
						$response = $this->httpGet($url);
						saveInFile($response, $data->code, 'json', "test/api/viator/product_detail/$destId");
					}

					if ($data->code == '38297P1') {
						$found = true;
					}


				}
			}
		}
	}

	public function fatchProductDetailBySavedData4()
	{
		// $destIds = [36, 37, 38, 39, 40, 51, 52, 53, 54, 55, 56, 4131, 4141, 4146, 4214, 4308, 4311, 4316, 4321, 4324, 4393, 4425, 4439, 4444, 4616, 4672, 4733, 4770, 4772, 4774, 4776, 4782, 4786, 4788, 4830, 4868, 4917, 5026, 5069, 5157, 5202, 5212, 5308, 5411, 5438, 5575, 5589, 21470, 21472, 21767, 21768, 21770, 21797, 21800, 21802, 21805, 21806, 21891, 21900, 21901, 21903, 21908, 21911, 21912, 21916, 21936, 21940, 22158, 22165, 22232, 22314, 22315, 22316, 22417, 25958, 26731, 26852, 27539, 29094, 32314];
		$destIds = [];

		$found = false;

		foreach ($destIds as $destId) {
			$recoveredData = file_get_contents("test/api/viator/product/$destId.json");
			$recoveredArrays = json_decode($recoveredData);
			
			if (!file_exists("test/api/viator/product_detail/$destId")) {
				mkdir("test/api/viator/product_detail/$destId");
			}

			if (isset($recoveredArrays->data) && is_array($recoveredArrays->data)) {
				foreach ($recoveredArrays->data as $data) {
					
					// if ($data->code == '17226P4') {
					// 	$found = true;
					// }
					
					// if ($found) {
						$url = $this->preLiveUrl."service/product?code=".$data->code."&currencyCode=USD&excludeTourGradeAvailability=false&apiKey=2134351327133057";

						$url = str_replace( "&amp;", "&", urldecode(trim($url)) );
						// dd($url);
						$response = $this->httpGet($url);
						saveInFile($response, $data->code, 'json', "test/api/viator/product_detail/$destId");
					// }


					
				}
			}
		}
	}


	public function fatchProductDetailBySavedData5()
	{
		// $destIds = [44, 45, 46, 47, 48, 49, 50, 57, 58, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70];
		$destIds = [];
		$found = false;

		foreach ($destIds as $destId) {
			$recoveredData = file_get_contents("test/api/viator/product/$destId.json");
			$recoveredArrays = json_decode($recoveredData);
			
			if (!file_exists("test/api/viator/product_detail/$destId")) {
				mkdir("test/api/viator/product_detail/$destId");
			}

			if (isset($recoveredArrays->data) && is_array($recoveredArrays->data)) {
				foreach ($recoveredArrays->data as $data) {
					
					if ($data->code == '21175P42') {
						$found = true;
					}
					
					if ($found) {
						$url = $this->preLiveUrl."service/product?code=".$data->code."&currencyCode=USD&excludeTourGradeAvailability=false&apiKey=2134351327133057";

						$url = str_replace( "&amp;", "&", urldecode(trim($url)) );
						// dd($url);
						$response = $this->httpGet($url);
						saveInFile($response, $data->code, 'json', "test/api/viator/product_detail/$destId");
					}
					
				}
			}
		}
	}

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


	/*
	| this function is for doing POST request 
	*/
	function do_post_request($url, $data, $optional_headers = null)
	{
		$params = array('http' => array(
			'method' => 'POST',
			'content' => $data
			));
		if ($optional_headers !== null) {
			$params['http']['header'] = $optional_headers;
		}
		$ctx = stream_context_create($params);
		$fp = @fopen($url, 'rb', false, $ctx);
		
		if (!$fp) {
			return null;
			// throw new \Exception("Problem with $url, $php_errormsg");
		}
		$response = @stream_get_contents($fp);
		if ($response === false) {
			return null;
			// throw new \Exception("Problem reading data from $url, $php_errormsg");
		}

		return $response;
	}


	/*
	| this function is for doing GET request 
	*/
	public function do_get_request($url)
	{
		$url = $this->removeAndSym($url);

		$url = htmlspecialchars_decode($url);

		$headers = @get_headers($url);
		
		if (isset($headers[0]) && $headers[0] == 'HTTP/1.1 200 OK') {
			$url = htmlspecialchars_decode($this->removeAndSym($url));
			return file_get_contents( $url );
		}else{
			return null;
		}
	}

	public function removeAndSym($string){
		if (findWord('&amp;', $string)) {
			$string = str_replace( "&amp;", "&", $string);
			return removeAndSym($string);
		}else{
			return $string;
		}
	}


	public function httpGet($url)
	{
		$ch = curl_init();  

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		//  curl_setopt($ch,CURLOPT_HEADER, false); 

		$output=curl_exec($ch);

		curl_close($ch);
		return $output == false ? null : $output;
	}

	function getProduct ( $code, $currencyCode )
	{
		global $prefix, $memcache, $cacheTime;
		dd($prefix);
		// create key for memcache
		$key = $prefix."_".$this->key."_"."getProduct"."-".$code."-".$currencyCode;

		// get the result from memcache if it's available
		$ret = $memcache->get( $key );
		// if not available, call the API
		if ( $ret === false )
		{
			// form the URL
			$url = getServiceURL() . "/service/product" . "?apiKey=" . $this->key .
			"&code=" . $code . "&currencyCode=".$currencyCode;
			// do the GET and decode the results
			$ret = json_decode ( file_get_contents( $url ) );
			// check the return object for a successful request
			if ( $ret->success === true )
			{
			// set the object into memcache for next time
				$memcache->set($key, $ret, false, $cacheTime);
			}
		}
		// return the data object
		return $ret;
	}

	public function fatchProductDetailBySavedDataParams($index,$to)
	{
		$destIds = [16, 17, 18, 19, 20, 21, 22, 23, 24, 27, 28, 29, 30, 31, 32, 34, 36, 37, 38, 39, 40, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 75, 76, 77, 78, 79, 80, 722, 723, 724, 725, 727, 728, 730, 731, 732, 734, 743, 744, 745, 746, 747, 748, 749, 778, 779, 780, 781, 801, 809, 810, 814, 825, 919, 927, 948, 963, 966, 967, 972, 4131, 4141, 4146, 4214, 4308, 4311, 4316, 4321, 4324, 4393, 4425, 4439, 4444, 4448, 4452, 4458, 4461, 4463, 4471, 4475, 4479, 4492, 4497, 4499, 4514, 4528, 4583, 4603, 4616, 4672, 4733, 4770, 4772, 4774, 4776, 4782, 4786, 4788, 4830, 4868, 4917, 5026, 5069, 5157, 5202, 5212, 5308, 5411, 5438, 5575, 5589, 21470, 21472, 21767, 21768, 21770, 21797, 21800, 21802, 21805, 21806, 21891, 21900, 21901, 21903, 21908, 21911, 21912, 21916, 21936, 21940, 22158, 22165, 22232, 22314, 22315, 22316, 22417, 25958, 26731, 26852, 27539, 29094, 32314];

		$found = false;

		for ($index=$index; $index <= $to; $index++) { 
			$destId = $destIds[$index];
			$recoveredData = file_get_contents("test/api/viator/product/$destId.json");
			$recoveredArrays = json_decode($recoveredData);
			
			if (!file_exists("test/api/viator/product_detail/$destId")) {
				mkdir("test/api/viator/product_detail/$destId");
			}

			if (isset($recoveredArrays->data) && is_array($recoveredArrays->data)) {
				foreach ($recoveredArrays->data as $data) {
					// if ($data->code == '37152P2') {
					// 	$found = true;
					// }

					// if ($found) {
						$url = $this->preLiveUrl."service/product?code=".$data->code."&currencyCode=USD&excludeTourGradeAvailability=false&apiKey=2134351327133057";

						$url = str_replace( "&amp;", "&", urldecode(trim($url)) );
						// dd($url);
						$response = $this->do_get_request($url);
						saveInFile($response, $data->code, 'json', "test/api/viator/product_detail/$destId");
					// }
				}
			}
		}
	}

	
	 

}
