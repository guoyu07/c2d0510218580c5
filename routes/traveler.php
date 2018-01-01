<?php

Route::group(['namespace' => 'TravelerAuth'], function(){

	Route::get('/login-register', 'LoginController@showLoginRegistrationForm');
	Route::get('/login', 'LoginController@redirectLogReg');
	Route::get('/register', 'LoginController@redirectLogReg');
	

	// Route::get('/login', 'LoginController@showLoginForm');
	Route::post('/login', 'LoginController@login');
	Route::post('/logout', 'LoginController@logout');


	// Route::get('/register', 'RegisterController@showRegistrationForm');
	Route::post('/register', 'RegisterController@register');

	Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail');
	Route::post('/password/reset', 'ResetPasswordController@reset');
	Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm');
	Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm');
});


Route::group(['namespace' => 'TravelerApp'], function(){

	Route::get('account/balance', 'HotelsController@getAgencyBalance');

	Route::get(
			'hotel/details/{id}/{index}', 
			'HotelsController@getHotelDetail'
		);

	Route::group(['middleware' => ['traveler']], function (){

		Route::group(['prefix' => 'myaccount'], function(){
			Route::group(['prefix' => 'booking'], function (){
				Route::get('history', 'BookingController@history');
				Route::get('detail/{token}', 'BookingController@detail')
								->name('traveler.booking.detail');
				Route::get('voucher/{token}', 'BookingController@getVoucher')
								->name('traveler.booking.voucher');

				Route::get('cancel/{token}', 'BookingController@getCancelBooking')
								->name('traveler.booking.cancel');

				Route::post('cancel/{token}', 'BookingController@postCancelBooking');
			});
		});

		Route::group(['prefix' => 'hotel/{id}'], function (){
			Route::get('room/block', 'HotelsController@getBlockRoom');
			Route::get('room/book', 'HotelsController@getBookRoom');
		});

		Route::get('/', 'PagesController@index');
		
	});

	Route::get('hotel/status/{token}', 'HotelsController@getRoomStatus')
					->name('traveler.hotel.status');

	Route::get('hotels', 'HotelsController@getHotels');
	Route::get('/home', 'PagesController@home');
	


	Route::group(['prefix' => 'api'], function (){
		
		Route::group(['prefix' => 'hotel/{id}/{index}'], function (){
			Route::get('rooms', 'HotelApiController@rooms');
			Route::get('details', 'HotelApiController@details');
		});

		Route::get('hotels', 'HotelApiController@hotels');
	});

});