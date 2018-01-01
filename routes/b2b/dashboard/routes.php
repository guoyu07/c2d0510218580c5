<?php 
/*-------------New enquiry creation will-------------*/
	// this route is to create package 
	// Route::get('{id}/n', 'RouteController@createPackage');
	
	// this route is gui to get information
	Route::group(['prefix' => 'route'], function () {
		Route::post('update/{id}', 'RouteController@updateRoute')
						->name('route.update');

		Route::get('{ctoken}/{token?}', 'RouteController@create')
						->middleware('packageIsLock')->name('createRoute');
		Route::post('{rid}/d', 'RouteController@deleteRow');
		Route::post('{pToken}/r', 'RouteController@storeRow');
		Route::post('{pToken}/u', 'RouteController@packageUpdate');
		Route::post('{pToken}/ro', 'RouteController@routeOrder');
		Route::post('{pToken}/ua', 'RouteController@updatePackageAttibutes');
		Route::post('{pToken}/room', 'RouteController@storeRoom');
		Route::post('{gid}/removeroom', 'RouteController@removeRoom');

		// this route will store the information into DB
		// Route::post('{id}/', 'RouteController@store');

		// this will update route in db only origin and destination
	});
