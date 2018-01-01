<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TbtqTokenModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'tbtq_tokens';
	protected $appends = ['status', 'token', 'expire_at'];
	protected $casts = ['request' => 'object', 'response' => 'object'];


	public function getTokenAttribute()
	{
		return isset($this->response->TokenId)
				 ? $this->response->TokenId
				 : null;
	}

	public function getStatusAttribute()
	{
		return isset($this->response->Status)
				 ? $this->response->Status
				 : 0;
	}


	public function getExpireAtAttribute()
	{
		// checking 23hr and 30 min
		return $this->created_at->addMinutes(1410);
	}



	public function scopeByExpireAt($query)
	{
		// finding last 23hr and 30 minutes token
		$date = Carbon::now()->subMinutes(1410);
		return $query->where('created_at', '>', $date);
	}


	public function makeGetAgencyBalance()
	{
		return $this->status == 1 ? [
						"ClientId" => env('TBTQ_HOTEL_CLIENTID'),
						"EndUserIp" => $_SERVER['REMOTE_ADDR'],
						"TokenAgencyId" => $this->response->Member->AgencyId,
						"TokenMemberId" => $this->response->Member->MemberId,
						"TokenId" => $this->token,
					] : null;
	}

}
