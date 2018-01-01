<?php 

	Route::group(['prefix' => 'todo'], function (){
		Route::post('status', 'ToDoController@status');
		Route::post('remove', 'ToDoController@remove');
		Route::post('all/json', 'ToDoController@postAllJson');
		Route::post('all/html', 'ToDoController@postAllHtml');
	});
	Route::resource('todo', 'ToDoController');
	
	Route::get('profile/password', 'ProfileController@getPassword');
	Route::put('profile/password', 'ProfileController@putPassword');
	Route::resource('profile', 'ProfileController');
	
	/*------------------------------index Route------------------------------*/
	Route::get('/', 'DashboardController@getIndex');

	/*--------------------------Tools Route--------------------------*/
	Route::group(['prefix' => 'tools'], function (){
		Route::get('/', 'DashboardToolsController@getIndex');
		Route::get('country', 'DashboardToolsController@getCountry');
		Route::get('calendar', 'DashboardToolsController@getCalendar');
		Route::get('vouchers/{type}', 'VoucherController@getVouchers');
		// get Request only
		// Route::get('airport/{request?}', 'DashboardToolsController@getAirport');
		// Route::get('destination/{request?}', 'DashboardToolsController@getDestination');

		// contact resource 
		Route::resource('contacts', 'ContactsController');
	});

	Route::group(['prefix' => 'monitoring'], function (){
		Route::get('packages', 'TrackPackageController@index')
					->name('packages.track');
	});


	/*-------------------------Enquiry Route-------------------------*/
	Route::resource('enquiry/', 'EnquiryController');
	Route::post('enquiry/pending', 'EnquiryController@pending');
	Route::get('enquiry/pending', 'EnquiryController@pending');

	/*------------------------Follow Up Route------------------------*/
	Route::get('follow-up/', 'FollowUpController@index');
	Route::post('follow-up/', 'FollowUpController@store');