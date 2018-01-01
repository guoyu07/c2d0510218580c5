<?php
	
Route::group(['namespace' => 'BackendAuth'], function(){
	include 'backend/public.php';
});

Route::group(['middleware' => ['backend'], 'namespace' => 'BackendApp'], function(){

	Route::group(['middleware' => ['backend.su']], function(){
		include 'backend/protected/su.php';
	});

	include 'backend/protected/default.php';
	include 'backend/protected/dashboard.php';
});