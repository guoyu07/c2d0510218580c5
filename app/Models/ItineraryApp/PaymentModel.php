<?php

namespace App\Models\ItineraryApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommonApp\PayuPaymentModel;

class PaymentModel extends Model
{
	protected $connection = 'mysql8';
	protected $table = 'payments';
	protected $appends = ['txnid'];

	public function getTxnidAttribute()
	{
		return isset($this->payuPayment->txnid)
				 ? $this->payuPayment->txnid
				 : null;
	}

	public function scopeByToken($query, $token)
	{
		return $query->where(['token' => $token]);
	}


	public function payuPayment()
	{
		return $this->morphOne(PayuPaymentModel::class, 'payable');
	}
		
}
