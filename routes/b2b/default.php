<?php 
	/*-------------------- Home, Main And Public Pages Route ----------------*/
	Route::get('home', 'PagesController@homeIndex');
	Route::get('about', 'PagesController@getAbout');
	Route::get('public', 'PagesController@getIndex');
	Route::get('logout', 'PagesController@getLogout');
	Route::get('contact', 'PagesController@getContact');
	Route::get('services', 'PagesController@getServices');
	Route::get('redirect/{hashId}', 'PagesController@redirectNow');

	// =====================Images Controller=====================
	Route::post('image/upload', 'ImagesController@upload');
	// Route::resource('new/destination', 'DestinationController');
