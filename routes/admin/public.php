<?php

Route::group(['namespace' => 'AdminApp'], function(){
	Route::get('/', 'PagesController@getHome');
	Route::get('home', 'PagesController@getHome');
});