<?php

namespace App\Http\Controllers\TravelerApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{

	public function index(Request $request)
	{
		return view('traveler.pages.index.main');
	}

	public function home()
	{
		return redirect('/');
	}
}
