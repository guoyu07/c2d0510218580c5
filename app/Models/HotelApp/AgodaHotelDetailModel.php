<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;

class AgodaHotelDetailModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql4';
	protected $table = 'agoda_hotel_details';

}
