<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonApp\VisaDetailModel;
use App\Traits\CallTrait;

class VisaDetailsController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new VisaDetailModel;
	}
}
