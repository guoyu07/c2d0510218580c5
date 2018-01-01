<?php

//Backend Login
Route::get('login', 'LoginController@showLoginForm');
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');
Route::post('logout', 'LoginController@logout');

//Backend Register
// Route::get('register', 'RegisterController@showRegistrationForm');
// Route::post('register', 'RegisterController@register');

//Backend Passwords
Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
Route::post('password/reset', 'ResetPasswordController@reset');
Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm');
Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm');
