<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackendApp\ChildChargeModel;
use App\Traits\CallTrait;



class ChildChargesController extends Controller
{
	use CallTrait;

	public function model(){
		return new ChildChargeModel; 
	}
}
