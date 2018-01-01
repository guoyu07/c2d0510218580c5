<?php 

	Route::get('home', 'PagesController@getHome');
	Route::get('/', 'PagesController@getIndex');
	Route::post('image/upload', 'ImagesController@upload');


	Route::post('/destination', 'DestinationController@postDestination');
	Route::post('/destination/option', 'DestinationController@postDestinationOption');
	
	Route::get('/destination/json', 'DestinationController@getDestination');

	Route::get('viator/activities/insert', 'ViatorActivitiesController@insertActivities');

	/*Route::get('/home', function () {
	    return view('backend.home');
	})->name('home');*/