<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\BookingHotelModel;
use App\Traits\CallTrait;


class BookingHotelsController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new BookingHotelModel;
	}



}
