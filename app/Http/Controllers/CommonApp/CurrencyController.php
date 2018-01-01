<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\CallTrait;

class CurrencyController extends Controller
{
	use CallTrait;
	public $attempt = 5;

	public function exchangeInJson(Request $request)
	{

		$currencies = [
									"USD/INR", "SGD/INR", "EUR/INR", 
									"AUD/INR", "AED/INR", "IDR/INR"
								];

		$response = $this->exchange($currencies);
		return json_encode($response);
	}



	/*
	| pass array as ["USD/INR", "SGD/INR", "EUR/INR", "AED/INR", "IDR/INR"]
	*/
	public function exchange(Array $currencies = []){

		$url = (empty($currencies))

				 ? 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22USDEUR%22,%20%22USDJPY%22,%20%22USDBGN%22,%20%22USDCZK%22,%20%22USDDKK%22,%20%22USDGBP%22,%20%22USDHUF%22,%20%22USDLTL%22,%20%22USDLVL%22,%20%22USDPLN%22,%20%22USDRON%22,%20%22USDSEK%22,%20%22USDCHF%22,%20%22USDNOK%22,%20%22USDHRK%22,%20%22USDRUB%22,%20%22USDTRY%22,%20%22USDAUD%22,%20%22USDBRL%22,%20%22USDCAD%22,%20%22USDCNY%22,%20%22USDHKD%22,%20%22USDIDR%22,%20%22USDILS%22,%20%22USDINR%22,%20%22USDKRW%22,%20%22USDMXN%22,%20%22USDMYR%22,%20%22USDNZD%22,%20%22USDPHP%22,%20%22USDSGD%22,%20%22USDTHB%22,%20%22USDZAR%22,%20%22USDISK%22)&format=json&env=store://datatables.org/alltableswithkeys'

				 : 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22'.str_replace('/', '', implode('%22,%20%22', $currencies)).'%22)&format=json&env=store://datatables.org/alltableswithkeys';


		$response = (object)[];

		for ($i=0; $i < $this->attempt; $i++) {
			$response = json_decode($this->httpGet($url));

			if (isset($response->query->results->rate)){
				if (is_object($response->query->results->rate)) {
					$response->query->results->rate = [$response->query->results->rate];
				}
				break;
			}
		}

		return $response;
	}



	
	public function xmlExchange($From, $To){

		$url = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22'.$From.$To.'%22)&env=store://datatables.org/alltableswithkeys';

		/*======================== this url for demo ========================*/
		$url = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22USDEUR%22,%20%22USDJPY%22,%20%22USDBGN%22,%20%22USDCZK%22,%20%22USDDKK%22,%20%22USDGBP%22,%20%22USDHUF%22,%20%22USDLTL%22,%20%22USDLVL%22,%20%22USDPLN%22,%20%22USDRON%22,%20%22USDSEK%22,%20%22USDCHF%22,%20%22USDNOK%22,%20%22USDHRK%22,%20%22USDRUB%22,%20%22USDTRY%22,%20%22USDAUD%22,%20%22USDBRL%22,%20%22USDCAD%22,%20%22USDCNY%22,%20%22USDHKD%22,%20%22USDIDR%22,%20%22USDILS%22,%20%22USDINR%22,%20%22USDKRW%22,%20%22USDMXN%22,%20%22USDMYR%22,%20%22USDNZD%22,%20%22USDPHP%22,%20%22USDSGD%22,%20%22USDTHB%22,%20%22USDZAR%22,%20%22USDISK%22)&env=store://datatables.org/alltableswithkeys';

		$response = \Curl::to($url)->post();

		return makeObject(simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA));
	}



	public function httpGet($url)
	{
		$ch = curl_init();  

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		//  curl_setopt($ch,CURLOPT_HEADER, false); 

		$output = curl_exec($ch);

		curl_close($ch);
		return $output;
	}

			
}
