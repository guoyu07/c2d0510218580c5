<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackendApp\ActivityCarModel;
use App\Traits\CallTrait;



class ActivityCarsController extends Controller
{
	use CallTrait;

	public function model(){
		return new ActivityCarModel; 
	}
}
