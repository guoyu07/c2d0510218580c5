<?php
	Route::group(['prefix' => 'admin/manage'], function(){
		Route::resource('users', 'UserController');
		Route::group(['prefix' => 'users'], function(){
			Route::get('verify/{token}', 'UserController@resendVerifyEmail');
			Route::get('password/{token}/reset', 'UserController@getResetPassword');
			Route::put('password/{token}/reset', 'UserController@putResetPassword');
			Route::put('suspend/{token}', 'UserController@suspendUser');
			Route::put('activate/{token}', 'UserController@activateUser');
		});	
	});