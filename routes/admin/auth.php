<?php 
Route::group(['namespace' => 'AdminAuth'], function(){

	Route::get('login', 'LoginController@showLoginForm');
	Route::post('login', 'LoginController@login');
	Route::post('logout', 'LoginController@logout');

	Route::get('register', 'RegisterController@showRegistrationForm');
	Route::post('register', 'RegisterController@register');

	Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
	Route::post('password/reset', 'ResetPasswordController@reset');
	
	Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm');
	Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm');
});