<?php 

	Route::group(['prefix' => 'dashboard'], function(){

		// Admin Console
		Route::group(['prefix' => 'console'], function(){
			Route::resource('manage/users', 'UserController');
			Route::group(['prefix' => 'manage/users'], function(){
				Route::get('verify/{token}', 'UserController@resendVerifyEmail');
				Route::get('password/{token}/reset', 'UserController@getResetPassword');
				Route::put('suspend/{token}', 'UserController@suspendUser');
				Route::put('activate/{token}', 'UserController@activateUser');
				Route::put('password/{token}/reset', 'UserController@putResetPassword');
			});
		});

		// Settings Section
		Route::group(['prefix' => 'settings'], function(){
			
			Route::group(['prefix' => 'text/{id}'], function(){
				Route::put('activate', 'TextController@activate');
				Route::put('deactivate', 'TextController@deactivate');
			});
			
			Route::resource('text', 'TextController');

			Route::group(['prefix' => 'vendor'], function(){
				Route::group(['prefix' => 'lead/{id}'], function(){
					Route::put('activate', 'LeadVendorController@activate');
					Route::put('deactivate', 'LeadVendorController@deactivate');
				});
				Route::resource('lead', 'LeadVendorController');
			});
		});


		Route::group(['prefix' => 'inventories'], function(){
			Route::get('activity/location', 'ActivitiesController@showLocation');

			Route::group(['prefix' => 'activity'], function(){
				Route::post('{id}/delete/{iid}', 'ActivitiesController@destroyImage');
				Route::post('store_ranks', 'ActivitiesController@storeOrUpdateRanks');
				Route::get('store/{id?}', 'ActivitiesController@createOrEdit');
				Route::post('store', 'ActivitiesController@storeOrUpdate');
				Route::put('{id}/deactivate', 'ActivitiesController@deactivate');
				Route::put('{id}/activate', 'ActivitiesController@activate');
			});

			Route::resource('activity', 'ActivitiesController');
		});


		Route::get('/', 'DashboardController@getIndex');
		
		Route::post('enquiry/{id}/active', 'EnquiryController@active');
		Route::resource('enquiry', 'EnquiryController');

		Route::get('profile', 'ProfileController@index');
		Route::get('profile/edit', 'ProfileController@edit');
		Route::post('profile/update', 'ProfileController@update');
	});