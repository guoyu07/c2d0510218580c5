<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackendApp\PlanModel;
use App\Traits\CallTrait;


class PlansController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new PlanModel;
	}

}
