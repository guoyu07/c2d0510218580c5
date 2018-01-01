<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;

class TbtqJsonBookingDetailModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'tbtq_json_booking_details';
	protected $appends = ['status', 'details'];
	protected $casts = ['request' => 'object', 'response' => 'object'];

	public function getStatusAttribute()
	{
		return isset($this->response->GetBookingDetailResult->ResponseStatus) 
				&& $this->response->GetBookingDetailResult->ResponseStatus == 1
				 ? 1
				 : 0;
	}


	public function scopeByRelationId($query, $id)
	{
		return $this->where('tbtq_json_room_book_id', '=', $id);
	}


	public function roomBooked()
	{
		return $this->belongsTo(
											'App\Models\HotelApp\TbtqJsonRoomBookModel', 
											'tbtq_json_room_book_id'
										);
	}


}
