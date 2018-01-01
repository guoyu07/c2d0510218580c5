<?php 
	
	// using this route url like ww...com/dashboard/package/*
	/*-----------Package all Route-----------*/
	Route::get(
		'preview/detail/{token}/{page?}', 
		'PackageController@routeToItinerary'
	)->name('package.preview');

	Route::get('not-modifiable', 'PackageController@notModifiable')
					->name('package.notmodifiable');

	Route::get('all', 'PackageController@index')
					->name('package.all');
	
	Route::get('open/{token}', 'PackageController@open')
					->name('openPackage');

	// Here all Package will show like list of package 
	Route::get('all/{token}', 'PackageController@show')
					->name('allPackage');

	Route::post('publish/{token}', 'PackageController@postPackagePublish')
					->name('package.publish');

	// this will save package cost
	Route::post('savecost/{token}', 'PackageController@saveCost')
					->name('saveCost');

	Route::post('savenote/{token}', 'PackageController@saveNote')
					->name('saveNote');

	Route::post('guests/{token}', 'RoomGuestsController@createOrUpdateRoom')
					->name('package.roomGuests');


	Route::post('sendpackageemail/{token}', 'PackageController@sendPackageEmail')
					->name('sendPackageEmail');
	

	// it will generate html of a specific package
	Route::get('html/{packageDbId}', 'PackageController@getCreatePdfHtml');

	// it will generate pdf of a specific package
	Route::get('pdf/{hashId}', 'PackageController@getCreatePdf');


	// this for finding next event
	Route::get('event/{routeDbId}', 'PackageController@getEvent');
	Route::get('builder/event/{token}/{current}', 'PackageController@getFindEvent');

	Route::get('replica/{pid}', 'PackageController@makePackageRaplica');

	Route::match(['get', 'post'], 'track/json', 'TrackPackageController@getActiveJson');


