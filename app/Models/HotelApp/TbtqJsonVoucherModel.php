<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;

class TbtqJsonVoucherModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'tbtq_json_vouchers';
	protected $casts = ['request' => 'object', 'response' => 'object'];
	protected $appends = ['status'];


	public function getStatusAttribute()
	{
		return isset($this->response->GenerateVoucherResult->ResponseStatus) 
				&& $this->response->GenerateVoucherResult->ResponseStatus == 1
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
