<?php

	/* ============================Cruise============================
	| id = Clients table index or id
	| packageDbId = packages table index or id
	|	packageCruiseId = package_cruises table or id
	*/
	Route::group(['prefix' => 'dashboard/package/builder/cruises'], function () {
		$controller = '';
		Route::get('{token}', 'CruisesController@getCruisesByToken');
		Route::post('remove/{routeId}', 'CruisesController@postRemoveHotel');
		Route::post('room/add/{routeId}', 'CruisesController@postAddHotelRoom');
		Route::post('selected/{routeId}', 'CruisesController@postSelectedHotel');
		Route::post('room/remove/{routeId}', 'CruisesController@postRemoveHotelRoom');
	});

	Route::get('dashboard/package/builder/cruises/{packageDbId?}', 'CruisesController@getCruisesByPackageId');
	// Book Cruise Room
	Route::post('dashboard/package/builder/cruise/cabin/book/{packageCruiseId}', 'CruisesController@postBookCrusieCabin');
	
	
	// Route::get('o/cruises/result', 'Api\CruiseController@cruises');
	// Route::get('check/cruises/result', 'CruisesController@itinerary');
	Route::get('fo/cruises/result/{id}', 'CruisesController@postFgfOnlyCruise');
	Route::post('fo/cruises/result/{id}', 'CruisesController@postFgfOnlyCruise');
	Route::get('f/cruises/result/{id}', 'CruisesController@postFgfCruiseResult');
	Route::get('f/cruises/result/{id}', 'CruisesController@postFgfCruiseResult');
	Route::post('f/cruises/result/{id}', 'CruisesController@postFgfCruiseResult');
	Route::get('f/cruises/cabin/{id}', 'CruisesController@postFgfCruiseCabin');
	Route::post('f/cruises/cabin/{id}', 'CruisesController@postFgfCruiseCabin');

	// Route::get('dashboard/api/cruise', 'Api\CruiseController@cruise');
	// Route::get('dashboard/api/cruise/cabin', 'Api\CruiseController@cruiseCabin');
	