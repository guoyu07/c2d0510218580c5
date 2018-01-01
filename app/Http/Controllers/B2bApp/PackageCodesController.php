<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\PackageCodeModel;
use App\Traits\CallTrait;

class PackageCodesController extends Controller
{
	use CallTrait;
	
	public function model()
	{
		return new PackageCodeModel;
	}

}
