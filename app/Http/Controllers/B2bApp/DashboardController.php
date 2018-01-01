<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\B2bApp\ClientController;
ini_set('max_execution_time', 180);


class DashboardController extends Controller
{
	public $viewPath = 'b2b.protected.dashboard.pages.index';

	public function getIndex($page = 'index'){

		if (View::exists('b2b.protected.dashboard.pages.'.$page.'.index')) {
			
			$newClient = new ClientController;
			$clientStatus = $newClient->model()->clientStatusData();
			$vendorReport = $newClient->model()->vendorReportToArray();
			/*
			| this is for time or clock which is showing time,
			| in that checking into that array which is second paramenter 
			| that page is in array if yes then show clock
			*/
			$onload = '';

			/* this code for clock
			if (in_array($page, ['index'])) {
				$onload = 'onload=startTime()';
			}*/

			/*$currenciesArray = ["USD", "SGD", "EUR", "AED", "IDR"];
			$currencies = [];
			
			foreach ($currenciesArray as $currenciesValue) {
				$exchange = currencyExchange($currenciesValue, "INR");
				$rate  = ifset($exchange->results->rate->Rate, 1);
				$rate = $rate+($rate*.02);
				$currencies[$currenciesValue] = $rate;
			}

			$maxCurrency = max($currencies);
			$currencies = rejson_decode($currencies);*/

			// =================Blade Object=================
			// $travelFeeds = travelFeed();

			$blade = [
					"other" => (object)["onload" => $onload],
					// "travelFeeds" => $travelFeeds,
					/*"currencyData" =>(object)[
								"currencies" => $currencies, 
								"maxCurrency" => $maxCurrency
							],*/
					"viewPath" => $this->viewPath,
					"clientStatus" => $clientStatus,
					"vendorReport" => $vendorReport,
				];

			return view('b2b.protected.dashboard.pages.'.$page.'.index', $blade);
		}
		else{
			return view('errors.404');
		}
	}
}
