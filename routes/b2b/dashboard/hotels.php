<?php
		
	Route::group(['prefix' => 'dashboard/package/builder/hotels'], function () {
		/*Route::get('{token}', 'HotelsController@getHotelsByToken');
		Route::post('remove/{routeId}', 'HotelsController@postRemoveHotel');
		Route::post('room/add/{routeId}', 'HotelsController@postAddHotelRoom');
		Route::post('selected/{routeId}', 'HotelsController@postSelectedHotel');
		Route::post('room/remove/{routeId}', 'HotelsController@postRemoveHotelRoom');*/

		/*Route::post('hotel/remove/{packageHotelId}', 'HotelsController@postRemoveHotelRoom');
		Route::get('hotel/room', 'HotelsController@postHotelRoom');
		Route::post('hotel/room/{packageHotelId}', 'HotelsController@postHotelRoom');
		Route::post('hotel/room/book/{packageHotelId}', 'HotelsController@postBookHotelRoom');*/
	});

	Route::group(['prefix' => 'fatch/hotels'], function () {
		Route::get('result/{id}', 'HotelsController@postHotelFromDb');
		Route::post('result/{id}', 'HotelsController@postHotelFromDb');
		Route::post('rooms/result', 'HotelsController@postHotelRoom');
	});


	Route::group(['prefix' => 'api/hotels'], function () {
		// Api Tbtq
		Route::post('t/result/{id}', 'HotelsController@postTbtqHotelResult');
		Route::get('tp/result/{id}', 'HotelsController@postTravelportHotels');

		// Api Skyscanner
		Route::post('ss/result/{id}', 'HotelsController@postSkyscannerHotelResult');
		
		// Agoda
		Route::post('a/result/{id}/{index?}', 'HotelsController@postFgfAgodaHotelResult');
		Route::post('a/rooms/{id}', 'HotelsController@postFgfAgodaHotelRoomResult');
		Route::post('a/detail/{id}', 'HotelsController@postFgfAgodaHotelDetail');

		// Booking Hotels 
		Route::get('b/result/{id}', 'HotelsController@postHotelFromDb');
		// Route::get('b/rooms/{id}', 'HotelApp\BookingHotelRoomsController@hotelRoom');
	});

		
	Route::get('dashboard/hotels/search/name/{id}', 'HotelsController@searchHotelNames');
	Route::post('dashboard/hotels/search/{id}', 'HotelsController@searchHotels');
	/*Route::post('dashboard/hotel/find/a/{id}', 'HotelsController@findHotel');
	Route::post('search/hotels/result/{id}', 'HotelsController@postHotelFromRename');
	Route::get('search/hotels/result/{id}', 'HotelsController@searchHotels');*/



