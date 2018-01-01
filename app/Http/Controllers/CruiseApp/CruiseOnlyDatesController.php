<?php

namespace App\Http\Controllers\CruiseApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CruiseApp\CruiseOnlyDateModel;
use App\Traits\CallTrait;

class CruiseOnlyDatesController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new CruiseOnlyDateModel;
	}

}
