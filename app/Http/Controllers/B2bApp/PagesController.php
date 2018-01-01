<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RedirectController;

// use URL;

class PagesController extends Controller
{
	public function getIndex(){
		return view('public.pages.home');
	}

	public function getHome(){
		return redirect('/#home');
	}

	public function homeIndex()
	{
    return redirect('dashboard');
	}

	public function getAbout(){
		return redirect('/#about');
	}

	public function getContact(){
		return redirect('/#contact');
	}

	public function getServices(){
		return redirect('/#services');
	}

	public function getLogout(){
		auth()->logout();
		return redirect('');
	}

	public function getTest(){
		return view('b2b.protected.dashboard.pages.form_advanced1');
	}

	public function getPickMe()
	{
		return 'Your cab is on the way';
	}

	public function redirectNow($hash)
	{
		return RedirectController::call()->redirectNow($hash);
	}


}
