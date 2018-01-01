<?php

	Route::group(['prefix' => 'agent'], function(){
		Route::get('wallet/cash', 'WalletController@addMoney')->name('addMoney');
		Route::get('transaction/{txnid}', 'TransectionController@show')
						->name('admin.showTransaction');
		/** @credits */
		Route::get('show/plan', 'PackageController@getShowPlans')
					 ->name('showPlans');
		Route::get('activate/plan/{planId}', 'PackageController@activatePlan')
					 ->name('activatePlan');
		Route::get('credits', 'PackageController@getShowPlans')
					 ->name('getCredits');

		Route::get('credits_checkout', 'PackageController@getCheckout')
					 ->name('creditsCheckout');
		Route::get('show/invoice/{txnid}', 'PackageController@showInvoice')
					 ->name('showInvoice');	

		/** @payments */
		Route::get('pay', 'PayumoneyController@pay')->name('pay');
		
		Route::match(['get', 'post'], 'pay/success','PayumoneyController@success')
					 ->name('paySuccess');
		Route::match(['get', 'post'], 'pay/failure', 'PayumoneyController@failure')
					 ->name('payFailure');
	});
