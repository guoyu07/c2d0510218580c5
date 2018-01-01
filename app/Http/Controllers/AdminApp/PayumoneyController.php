<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminApp\TransectionController;
use App\Models\CommonApp\PayuPaymentModel;
use App\Traits\CallTrait;

class PayumoneyController extends Controller
{	
	use CallTrait;
	
	private $data = [
			"auth" => null,
			"txnid" => null,
			"mode" => 'secure',
			"testUrl" => 'https://test.payu.in/_payment',
			"secureUrl" => 'https://secure.payu.in/_payment',
			"surl" => '',
			"furl" => '',
		];

	public function model()
	{
		return new PayuPaymentModel;
	}

	/*
	| request must have these parameter
	| amount, product
	*/
	public function pay(Request $request)
	{
		// dd(strtolower(hash("sha512", 'PC4HRz84|149700717566341|10.29|add_money|Aashwin|info@flygoldfinch.com|||||||||||yKLVumd1KE')));

		$this->mode = 'test';

		// credentials
		$key = $this->key;
		$salt = $this->salt;

		// urls
		$url = $this->url;
		$surl = $this->surl;
		$furl = $this->furl;

		$txnid = $this->txnid;
		// user detail here
		$name = $this->auth->firstname;
		$email = $this->auth->email;
		$phone = $this->auth->mobile;

		// Request data here
		$amount = $request->amount;

		$productinfo = isset($request->product) 
								 ? $request->product
								 : 'add_money';
		

		// hashing here
		$hashseq = $key.'|'.$txnid.'|'.$amount.'|'
								.$productinfo.'|'.$name.'|'.$email
									.'|||||||||||'.$salt;

		$hash = strtolower(hash("sha512", $hashseq)); 	


		$blade = [
				"key" 				=> $key,
				"url" 				=> $url,
				"salt" 				=> $salt,
				"surl" 				=> $surl,
				"furl" 				=> $furl,
				"name" 				=> $name,
				"hash" 				=> $hash,
				"txnid" 			=> $txnid,
				"phone" 			=> $phone,
				"email" 			=> $email,
				"amount" 			=> $amount,
				"hashseq" 		=> $hashseq,
				"productinfo" => $productinfo,
			];

		// dd($blade);


		$request->merge($blade);
		$this->store($request);

		return view('admin.protected.dashboard.pages.payumoney.index', $blade);
	}


	public function success(Request $request)
	{
		$request->merge(['is_success' => 1]);
		$payu = $this->update($request);
		return redirect()->route('admin.showTransaction', $payu->txnid);
	}


	public function failure(Request $request)
	{
		$request->merge(['is_success' => 0]);
		$payu = $this->update($request);
		return redirect()->route('admin.showTransaction', $payu->txnid);
	}


	public function store(Request $request)
	{
		$payu = $this->model();
		$payu->txnid = $request->txnid;
		$payu->payable_id = $this->auth->id;
		$payu->payable_type = 'App\\Admin';
		$payu->amount = $request->amount;
		$payu->net_amount = $request->net_amount;
		$payu->request = $request->input();
		$payu->save();
		return $payu;
	}


	public function update(Request $request)
	{
		$payu = $this->model()->findByTxnidOrElse($request->txnid);
		$payu->is_success =  $request->is_success;
		$payu->data = $request->input();
		$payu->save();

		//  this call first for showing previous balance
		$trans = (object) [
				'uid' => $request->txnid,
				'deposited' => $request->amount,
				'is_success' => $request->is_success,
				'tran_type' => 'deposited',
				'conjoinly_id' => $payu->id,
				'conjoinly_type' => 'App\\Models\\AdminApp\\PayuPaymentModel'
			];

		TransectionController::call()->new($trans);

		// this call seconed for updating current balance
		if ($request->is_success) {
			$this->auth->balance += $payu->net_amount;
			$this->auth->save();
		}

		return $payu;
	}



	public function __set($name, $value)
	{
		if (isset($this->data[$name])) {
			$this->data[$name] = $value;
		}
		else{
			$this->$name = $value;
		}
	}

	public function __get($name)
	{
		$data = (object) $this->data;
		$value = null;

		if ($name == 'auth') {
			if (is_null($this->data['auth'])) {
				$this->data['auth'] = auth()->guard('admin')->user();
			}
			$value = $this->data['auth'];
		}
		elseif ($name == 'txnid') {
			$value = uid();
		}
		elseif(isset($this->data[$name])) {
			$value = $this->data[$name];
		}
		elseif ($this->mode == 'secure'){
			if ($name == 'url') {
				$value = $data->secureUrl;
			}
			elseif ($name == 'key') {
				$value = env('PAYUMONEY_KEY');
			}
			elseif ($name == 'salt') {
				$value = env('PAYUMONEY_SALT');
			}
		}
		elseif ($this->mode == 'test') {
			if ($name == 'url') {
				$value = $data->testUrl;
			}
			elseif ($name == 'key') {
				$value = env('TEST_PAYUMONEY_KEY');
			}
			elseif ($name == 'salt') {
				$value = env('TEST_PAYUMONEY_SALT');
			}
		}
		return $value;
	}


	public function __construct()
	{
		$this->surl = url('agent/pay/success');
		$this->furl = url('agent/pay/failure');
	}

}
