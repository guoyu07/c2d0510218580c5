<?php

namespace App\Http\Controllers\CruiseApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CruiseApp\CruisePriceModel;
use App\Traits\CallTrait;

class CruisePriceController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new CruisePriceModel;
	}


}
