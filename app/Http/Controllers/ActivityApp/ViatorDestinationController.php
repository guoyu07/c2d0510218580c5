<?php

namespace App\Http\Controllers\ActivityApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivityApp\ViatorDestinationModel;
use App\Traits\CallTrait;


class ViatorDestinationController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new ViatorDestinationModel;
	}


}
