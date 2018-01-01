<?php 

	Route::get('dashboard/package/builder/car/{packageDbId}', 'CarsController@create');

	Route::post('dashboard/package/builder/car/{packageDbId}', 'CarsController@postCar');

	Route::post('dashboard/package/builder/car/{packageDbId}/choose', 'CarsController@chooseCar');

	Route::post('dashboard/package/builder/car/{packageDbId}/menu', 'CarsController@postMenu');

	Route::delete('dashboard/package/builder/car/{packageDbId}', 'CarsController@destroy');

	Route::get('skyscanner/cars', 'CarsController@getCars');
	Route::get('skyscanner/test/cars', 'SkyscannerCarsController@test');

	
	Route::get('dashboard/uber/request', 'Api\UberApiController@testRequestRide');
	Route::get('dashboard/uber', 'UberController@getUber');
	Route::any('dashboard/uber/auth', 'UberController@auth');
	Route::get('dashboard/uber/product', 'UberController@getProductsTest');
	Route::get('dashboard/buber', 'UberController@basvandorstUber');
