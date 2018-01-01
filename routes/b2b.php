<?php

Auth::routes();
require 'b2b/public.php';

Route::group(['middleware' => ['auth'], 'namespace' => 'B2bApp'], function(){
	require 'b2b/default.php';

	// ===========================To-Do ==========================
	Route::group(['prefix' => 'dashboard'], function () {
		require 'b2b/dashboard/default.php';

		Route::group(['prefix' => 'package'], function () {
			require 'b2b/dashboard/packages.php';
			require 'b2b/dashboard/routes.php';
		});
	});
	
	require 'b2b/dashboard/flights.php';
	require 'b2b/dashboard/hotels.php';
	require 'b2b/dashboard/cruises.php';
	require 'b2b/dashboard/accomo.php';
	require 'b2b/dashboard/activities.php';
	require 'b2b/dashboard/cars.php';
	require 'b2b/dashboard/cabs.php';
	require 'b2b/dashboard/temp.php';
});

