<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\AgodaHotelImageModel;
use App\Traits\CallTrait;

class AgodaHotelImagesController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new AgodaHotelImageModel;
	}

}
