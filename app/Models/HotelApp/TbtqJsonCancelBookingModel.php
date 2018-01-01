<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\HotelApp\TbtqTokenController;


class TbtqJsonCancelBookingModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'tbtq_json_cancel_bookings';
	protected $appends = [
							'send_change_status', 'get_change_status', 
							'change_request_id', 'get_change_message',
							'change_request_status', 'refund_amount',
							'cancellation_charge'
						];

	protected $casts = [
							'send_change_request' => 'object',
							'send_change_response' => 'object',
							'get_change_request' => 'object',
							'get_change_response' => 'object'
						];


	public function getSendChangeStatusAttribute()
	{
		return isset($this->send_change_response
												->HotelChangeRequestResult
													->ResponseStatus)
					&& $this->send_change_response
												->HotelChangeRequestResult
													->ResponseStatus == 1
					? 1
					: 0;
	}


	public function getGetChangeStatusAttribute()
	{
		return isset($this->send_change_response
												->HotelChangeRequestStatusResult
													->ResponseStatus)
					&& $this->send_change_response
												->HotelChangeRequestStatusResult
													->ResponseStatus == 1
					? 1
					: 0;
	}


	public function getChangeRequestIdAttribute()
	{
		return $this->send_change_status 
				 ? $this->send_change_response
				 					->HotelChangeRequestResult
				 						->ChangeRequestId
				 : null;
	}


	public function getChangeRequestStatusAttribute()
	{
		return isset($this->get_change_response->Response->ChangeRequestStatus)
				 ? $this->get_change_response->Response->ChangeRequestStatus
				 : 5; // this is the custom error status
	}


	public function getRefundAmountAttribute()
	{
		return isset($this->get_change_response->Response->RefundAmount)
				 ? $this->get_change_response->Response->RefundAmount
				 : null;
	}


	public function getCancellationChargeAttribute()
	{
		return isset($this->get_change_response->Response->CancellationCharge)
				 ? $this->get_change_response->Response->CancellationCharge
				 : null;
	}

	public function getGetChangeMessageAttribute()
	{
		$msgs = [
				'We couldn\'t process your request due to some technical issue. Please contact customer care for details.',
				'Cancellation status pending please wait or contact customer care for details.',
				'Cancellation in progress please wait or contact customer care for details.',
				'Cancellation is processed please wait or contact customer care for details.'
			];

		return isset($msgs[$this->change_request_status])
				 ? $msgs[$this->change_request_status]
				 : $msgs[0];
	}


	public function messageCss()
	{
		return $this->change_request_status != 3 ? 'alert-danger' : ''; 
	}

	

	public function scopeByRelationId($query, $relationId)
	{
		return $query->where('tbtq_json_room_book_id', '=', $relationId);
	}


	public function makeGetChangeRequest()
	{
		$token = TbtqTokenController::call()->token();

		return !$this->send_change_status ? null :  [
							"ChangeRequestId" => $this->change_request_id,
							"EndUserIp" => $_SERVER['REMOTE_ADDR'],
							"TokenId" => $token->token,
						];
	}

}
