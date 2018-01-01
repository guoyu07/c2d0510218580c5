<?php

namespace App\Http\Controllers\ActivityApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivityApp\ViatorActivityModel;
use App\Traits\CallTrait;

class ViatorActivitiesController extends Controller
{
	use CallTrait;
	

	public function model()
	{
		return new ViatorActivityModel;
	}


}
