<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\HotelApp\CoordinateTrait;
use App\Traits\Models\HotelApp\ScopeSearchTrait;

class HotelModel extends Model
{
	use CoordinateTrait, ScopeSearchTrait;

	protected $connection  = 'mysql4';
	protected $table = 'hotels';
	protected $appends = ['vendor_code'];
	protected $hidden = ['created_at', 'updated_at'];
	protected $searchColumnName = 'name';

	public function getVendorCodeAttribute()
	{
		$vendors = [
				'App\Models\HotelApp\AgodaHotelModel' => 'a',
				'App\Models\HotelApp\BookingHotelModel' => 'b',
				'App\Models\HotelApp\TbtqHotelModel' => 't'
			];

		return isset($vendors[$this->vendor_type])
				 ? $vendors[$this->vendor_type]
				 : '';
	}



	public function scopeByVendor($query, $vendor = 'b')
	{
		$vendors = [
					'a' => '%AgodaHotelModel',
					'b' => '%BookingHotelModel',
					't' => '%TbtqHotelModel'
				];
		
		$vendor = isset($vendors[$vendor]) 
						? $vendors[$vendor] 
						: $vendors['b'];

		return $query->where('vendor_type', 'like', $vendor);
	}



	public function vendor()
	{
		return $this->morphTo();
	}


}
