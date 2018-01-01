<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;

class PayuPaymentModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'payu_payments';
	protected $casts = ['request' => 'object', 'data' => 'object'];

	public function findByTxnid($txnId)
	{
		return $this->where(['txnid' => $txnId])->first();
	}


	public function findByTxnidOrElse($txnid, $exec = 'wrong')
	{
		$result = $this->findByTxnid($txnid);
		if (is_null($result)) {
			if ($exec == 'wrong') {
				wrongView();
			}
			exitView();
		}
		return $result;
	}

	public function backUrl($status)
	{
		$url = $this->furl;
		if ($status) {
			$url = $this->surl;
		}
		return $url;
	}


	public function payable()
	{
		$this->morphTo();
	}


}
