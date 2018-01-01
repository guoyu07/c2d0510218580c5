<?php

Route::post('package/ping/{token}', 'B2bApp\TrackPackageController@trackPing')
				->name('trackPing');

Route::group(['namespace' => 'ItineraryApp'], function(){
	Route::group(['prefix' => 'your/package'], function (){

		Route::get('detail/{token}/{page?}', 'PagesController@pages')
						->name('yourPackage');

		Route::any('payment/{status}/{token}', 'PaymentsController@response')
						->name('payStatusUrl');

		Route::any('reserve/{token}', 'ReservesController@reserve')
						->name('reservePackage');

		Route::any('pay/{token}', 'PaymentsController@payNow')
						->name('payPackage');
	});
});