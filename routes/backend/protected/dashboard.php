<?php 
	
Route::group(['prefix' => 'dashboard'], function (){

	Route::group(['prefix' => 'manage/location'], function (){
		Route::resource('country', 'CountryController');
		Route::resource('destination', 'DestinationController');
		// Route::resource('images', 'ImagesController');
	});

	Route::group(['prefix' => 'manage/images'], function (){
		Route::get('/', 'ImagesController@index');
		Route::post('{type}/{pid}/delete/{id}', 'ImagesController@destroy');
		Route::get('{type}/{pid}/create', 'ImagesController@create');
		Route::get('{type}/{pid}', 'ImagesController@show');
		Route::post('{type}/{pid}', 'ImagesController@store');
	});

	// Activities Group
	Route::group(['prefix' => 'activities'], function (){
		$cont = 'ActivitiesController';
		Route::get('all', $cont.'@all');
		Route::get('destination', $cont.'@selectDestination');

		Route::post('f/{id}/rank', $cont.'@rank');
		Route::post('v/{id}/rank', 'ViatorActivitiesController@rank');
		Route::post('saveimage', $cont.'@storeImage');

		Route::resource('/', $cont);
		Route::resource('v', 'ViatorActivitiesController');
	});

	Route::get('/', 'DashboardController@getIndex');

});