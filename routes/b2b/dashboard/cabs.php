<?php 
//==============================Cabs==============================
	Route::get('dashboard/package/builder/cab/auth', 'Api\UberApiController@auth');
	Route::get('dashboard/package/builder/cab/auth/token', 'Api\UberApiController@getToken');
	Route::get('dashboard/package/builder/cab/current', 'Api\UberApiController@testCurrentRequest');

	Route::get('dashboard/package/builder/cab/{id}/{packageDbId}', 'CabsController@index');
	
	Route::post('dashboard/package/builder/cab/{id}/{packageDbId}', 'CabsController@postProduct');
	Route::post('dashboard/package/builder/cab/book/{id}/{packageDbId}', 'CabsController@postBook');
	Route::post('dashboard/package/builder/cab/pickup/{id}/{packageDbId}', 'CabsController@postPickUp');
