<?php 

	Route::group(['prefix' => 'dashboard/package/builder/activities'], function () {
		Route::get('{token}', 'ActivitiesController@getActivitiesByToken')
						->middleware('packageIsLock')->name('activities');

		Route::post('add/{rtoken}', 'ActivitiesController@postAddActivity');
		Route::post('remove/{rtoken}', 'ActivitiesController@postRemoveActivity');
	});

	Route::group(['prefix' => 'api/package/activities'], function () {
		Route::any('fatch/{rtoken}', 'ActivitiesController@postFatchActivities');
		Route::get('names/{rtoken}','ActivitiesController@getActivityNames');
		Route::any('search/{rtoken}','ActivitiesController@postActivitiesSearch');
	});

	Route::group(['prefix' => 'my/activity'], function () {
		Route::any('store/{rtoken}', 'ActivitiesController@storeActivity');
	});


/*
	// Route::get('vtr/activities/result/{id}', 'ActivitiesController@postViatorActivitiesResult');
	// Route::post('fgf/activities/result/{id}', 'ActivitiesController@postFgfActivitiesResult');
	// Route::post('vtr/activities/result/{id}', 'ActivitiesController@postViatorActivitiesResult');

	//Route::get('scrape/data/activities', 'Api\ScrapeController@expedia');
*/
