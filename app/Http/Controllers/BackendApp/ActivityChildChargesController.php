<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackendApp\ActivityChildChargeModel;
use App\Traits\CallTrait;


class ActivityChildChargesController extends Controller
{
	use CallTrait;

	public function model(){
		return new ActivityChildChargeModel; 
	}
}
