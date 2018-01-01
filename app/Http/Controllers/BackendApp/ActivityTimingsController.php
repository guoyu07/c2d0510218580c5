<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackendApp\ActivityTimingModel;
use App\Traits\CallTrait;


class ActivityTimingsController extends Controller
{
	use CallTrait;

	public function model(){
		return new ActivityTimingModel; 
	}
}
