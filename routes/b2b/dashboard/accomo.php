<?php
	$ac = 'AccommodationController';

	Route::group(['prefix' => 'dashboard/package/builder/accommodation'], function () use ($ac) {
		Route::post('add/own/property/type', $ac.'@addPropertyManually')
					->name('accomo.add_own_property');
		Route::post('add/attributes/{rid}', $ac.'@postAddAttributes');
		Route::post('prop/remove/{rid}', $ac.'@postRemoveProp');
		Route::post('prop/add/{rid}', $ac.'@postAddProp');
		Route::post('remove/{rid}', $ac.'@postRemoveAccomo');
		Route::get('{token}', $ac.'@getHotelsByToken')
						->middleware('packageIsLock')->name('accommo');

	});

	Route::group(['prefix' => 'api/package/accommodation', 'middleware' => 'check.route'], function () use ($ac){
		Route::match(
								['get', 'post'], 
								'search/name/{rtoken}',
								 $ac.'@searchProp'
							)
						->name('accomo.searchProp');

		Route::group(['prefix' => 'fatch'], function () use ($ac){
			Route::post('facilities/{rtoken}', $ac.'@postAccomoFacilities');
			Route::post('images/{rtoken}', $ac.'@postAccomoImages');
			Route::post('prop/{rtoken}', $ac.'@postAccomoProp');
			Route::post('{rtoken}', $ac.'@postAccomo');

			if (env('IS_LOCALHOST')) {
				Route::get('{rtoken}', $ac.'@postAccomo');
				Route::get('prop/{rtoken}', $ac.'@postAccomoProp');
				Route::get('images/{rtoken}', $ac.'@postAccomoImages');
				Route::get('facilities/{rtoken}', $ac.'@postAccomoFacilities');
			}
		});
	});