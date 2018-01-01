<?php

	include('admin/auth.php');
	include('admin/public.php');

	Route::group(['middleware' => ['admin'], 'namespace' => 'AdminApp'], function(){
		include('admin/protected/agent.php');
		include('admin/protected/dashboard.php');
	});
