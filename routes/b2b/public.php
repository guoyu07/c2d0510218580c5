<?php 
	Route::get('user/activation/{token}', 'AdminApp\UserController@activatePendingUser')
						->name('activatePendingUser');
	Route::get('', 'B2bApp\PagesController@getIndex');
	Route::get('a/l/htdetail', 'HotelApp\AgodaHotelsController@loopHotelDetails');
	Route::get('tp/hotels/result','HotelApp\TravelportHotelController@hotels');
