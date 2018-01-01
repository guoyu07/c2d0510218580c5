<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EanApiController extends Controller
{
	public function auth(){
		
		$secret = 'y9cGTTTU';
		$host = 'http://api.ean.com/';

		// build path
		$ver = 'v3/';
		$method = 'list/';
		// http://api.ean.com/ean-services/rs/hotel/v3/avail?
		$path = "ean-services/rs/hotel/{$ver}{$method}";

		// query parameters
		$apiKey = '[2r5r4ttek2xqvushfvnw67yh]';
		$cid = '[04443]'; // WI04443
		$minorRev = '[24]';
		$customerUserAgent = 'Mozilla/4.0';
		$customerIpAddress = '103.196.53.14';
		$locale = 'en_US';
		$currencyCode = 'USD';
		$hotelId = '201252';

		$timestamp = gmdate('U');
		$sig = md5($apiKey . $secret . $timestamp);

		$query = "?apikey={$apiKey}&cid={$cid}&sig={$sig}&minorRev={$minorRev}"
		. "&customerUserAgent={$customerUserAgent}&customerIpAddress={$customerIpAddress}"
		. "&locale={$locale}&currencyCode={$currencyCode}&hotelIdList={$hotelId}";
		
		echo $query;

		// initiate curl
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $host . $path . $query);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept:application/json'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		$headers = curl_getinfo($ch);

		// close curl
		curl_close($ch);

		// return XML data
		if ($headers['http_code'] != '200') {
		 echo "An error has occurred.";
		return false;
		} else {
		 pre_echo(json_decode($data));
		 // return($data);
		}
	}

	public function getEan($url)
	{

		// initiate curl
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $host . $path . $query);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept:application/json'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		$headers = curl_getinfo($ch);

		// close curl
		curl_close($ch);
	}

	public function auth1()
	{
		$apiKey = '2r5r4ttek2xqvushfvnw67yh';
		$customerUserAgent = urlencode($_SERVER['HTTP_USER_AGENT']);
		$customerIpAddress = $_SERVER["REMOTE_ADDR"];
		$customerSessionId = "";

		$url = 'https://api.eancdn.com/ean-services/rs/hotel/v3/geoSearch?cid=55505';  //Use this if site go live 'http://api.ean.com/ean-services/rs/hotel/v3/geoSearch'

		$append = '&minorRev=99';
		$append .= '&apiKey=' . $apiKey;
		$append .= '&customerSessionId=' . $customerSessionId;
		$append .= '&customerUserAgent=' . $customerUserAgent;
		$append .= '&customerIpAddress=' . $customerIpAddress;
		$append .= '&locale=en_US';
		$append .= '&currencyCode=USD';

		$xml = '<LocationInfoRequest>';
		$xml .= '<destinationString>' .'delhi'. '</destinationString>';
		$xml .= '<type>1</type>';
		$xml .= '</LocationInfoRequest>';

		$sendurl = $url . $append . '&xml=' . urlencode($xml);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $sendurl);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 65000);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/xml"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);
		$info = curl_getinfo($ch);

		curl_close($ch);

		//Transform Response into Object:
		$xmlBody = substr($response, $info['header_size']);
		echo $xmlBody;
		$hotelinfo = simplexml_load_string($xmlBody);
		pre_echo($hotelinfo);
	}

}
