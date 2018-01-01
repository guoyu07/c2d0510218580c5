<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ==============================Api Controller==============================
use App\Http\Controllers\CommonApp\AirportController;
use App\Http\Controllers\CommonApp\DestinationController;

use App\Models\CommonApp\Location;
use App\Models\CommonApp\Airport;

class DashboardToolsController extends Controller
{

	public function getIndex(){
		return view('b2b.protected.dashboard.pages.tools.index');
	}

	public function getCalendar(){
		return view('b2b.protected.dashboard.pages.calendar.index');
	}


}
