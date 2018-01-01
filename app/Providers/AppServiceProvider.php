<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\B2bApp\ToDoController;
use App\Http\Controllers\B2bApp\ClientController;
use App\Http\Controllers\B2bApp\FollowUpController;
use View;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{

		View::composer('b2b.*', function($view){
			$view->with('auth', auth()->user());
		});

		View::composer('admin.*', function($view){
			$view->with('auth', auth()->guard('admin')->user());
		});
		
		View::composer('backend.*', function($view){
			$view->with('auth', auth()->guard('backend')->user());
		});

		View::composer('traveler.*', function($view){
			$view->with('auth', auth()->guard('traveler')->user());
		});

		$domain = isset($_SERVER['HTTP_HOST']) 
						? $_SERVER['HTTP_HOST']
						: env('B2B_DOMAIN');

		if (in_array($domain, [env('B2B_DOMAIN')]) ) {
			View::composer('b2b.*', function($view){
				$view->with('todos', ToDoController::call()->all());
			});

			View::composer('b2b.*', function($view){
				// $view->with('pendingLeads',  ClientController::call()->pendingClients());
			});

			View::composer('b2b.*', function($view){
				// $view->with('pendingFollowUps',  FollowUpController::call()->all());
			});
		}

	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
