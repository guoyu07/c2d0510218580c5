<?php 
	Route::group(['prefix' => 'dashboard/package/builder'], function () {

		Route::get('flights/{token}', 'FlightsController@getFlightsByToken')
						/*->middleware('packageIsLock')*/->name('flights');

		Route::post(
					'flight/book/{rtoken}', 
					'FlightsController@postBookFlightsResult'
				);

		Route::delete(
					'flight/book/{rtoken}', 
					'FlightsController@deleteBookFlightResult'
				);

		Route::delete('flight/{routeId}', 'FlightsController@removeFlight');

	});


	Route::group(['prefix' => 'custom/flights'], function (){
		Route::post('add', 'FlightsController@saveCustomFlights');
		Route::post('remove/{id}', 'FlightsController@removeCustomFlights');
	});


	Route::group(['prefix' => 'api/flights'], function () {
		Route::post(
			'result/{vendor}/{rtoken}', 
			'FlightsController@postFlightResult'
		);

		Route::get('tp/result/{id}', 'FlightsController@postTravelportFlight');
	});

	Route::post(
		'qpx/flights/result/{id}', 
		'FlightsController@postQpxFlightResult'
	);



	
	Route::post(
		'ss/flights/result/{id}', 
		'FlightsController@postSkyscannerFlightResult'
	);

	// Route::get('tp/flights/result', 'TravelportAirController@index');
	// Route::get('skyscanner/flights', 'Api\SkyscannerFlightsApiController@postFlight');
