<?php

	Route::group(['namespace' => 'CommonApp'], function(){
		Route::post('api/image/upload', 'ImageController@upload');
		
		Route::any(
						'secure/payment/{status}/{txnid}', 
						'PayuPaymentsController@response'
					)->name('payuRes');
		
		Route::get(
				'location/detail/fatch/airport', 
				'AirportController@getAirport'
			)->name('fatchAirports');

		Route::get(
				'location/detail/airport/names', 
				'AirportController@names'
			)->name('airport.names');

		Route::get(
				'location/detail/fatch/destination', 
				'DestinationController@getDestination'
			)->name('fatchDestinations');

		Route::get(
				'location/detail/destination/names', 
				'DestinationController@names'
			)->name('destination.names');


		Route::group(['prefix' => 'api'], function(){
			Route::get('currency/exchange', 'CurrencyController@exchangeInJson');
		});

	});

	Route::group(['namespace' => 'FlightApp', 'prefix' => 'flights'], function(){
		Route::get('airline/names', 'AirlinesController@names')
						->name('airlines.name');
	});

