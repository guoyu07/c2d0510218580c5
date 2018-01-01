<?php

namespace App\Models\AdminApp;

use Illuminate\Database\Eloquent\Model;


class TransectionModel extends Model
{
	protected $connection = 'mysql3';
	protected $table = 'transactions';
	protected $appends = ['amount'];

	public function setAdminIdAttribute()
	{
		$auth = auth()->guard('admin')->user();
		$this->attributes['admin_id'] = $auth->id;
	}

	public function setBalanceAttribute()
	{
		$auth = auth()->guard('admin')->user();
		$this->attributes['balance'] = $auth->balance;		
	}

	public function getAmountAttribute()
	{
		$result = $this->balance;
		
		if ($this->tran_type == 'deposited' && $this->is_success) {
			$result += $this->deposited;
		}
		elseif ($this->tran_type == 'withdrawn' && $this->is_success) {
			$result -= $this->withdrawn;
		}
		elseif ($this->tran_type == 'plan_taken' && $this->is_success) {
			$plan = $this->plan;
			$total = isset($plan->total) ? $plan->total : 0;
			$result = $this->balance-$total;
		}

		return $result;
	}

	

	public function findByUidOrExit($uid)
	{
		$result = $this->where(['uid' => $uid])->first();
		if (is_null($result)) {
			exitView();
		}
		return $result;
	}



	public function plan()
	{
		return $this->belongsTo('App\Models\BackendApp\PlanModel', 'plan_id');
	}


	public function conjoinly()
	{
		return morphTo();
	}


	public function payuPayments()
	{
		return $this->belongsTo('App\Models\AdminApp\PayuPaymentModel', 'uid', 'txnid');
	}

	public function __construct(array $attributes = [])
	{
		$this->setAdminIdAttribute();
		$this->setBalanceAttribute();
		parent::__construct($attributes);
	}

}
