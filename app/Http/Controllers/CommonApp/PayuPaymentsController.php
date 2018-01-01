<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonApp\PayuPaymentModel;
use App\Traits\CallTrait;

class PayuPaymentsController extends Controller
{
	use CallTrait;

	public $mode = 'secure';
	public $testUrl = 'https://test.payu.in/_payment';
	public $secureUrl = 'https://secure.payu.in/_payment';


	public function model()
	{
		return new PayuPaymentModel;
	}


	public function index(Array $data)
	{
		$this->checkData($data);
		$data['txnid'] = uid();
		$request = new Request($data);

		$hashseq = $request->key.'|'.$request->txnid.'|'
								.$request->amount.'|'.$request->productinfo
									.'|'.$request->name.'|'.$request->email
										.'|||||||||||'.$request->salt;

		$hash = strtolower(hash("sha512", $hashseq));
		$request->merge(["hashseq" => $hashseq, "hash" => $hash]);

		$this->store($request);

		$blade = [
				"txnid" 			=> $request->txnid,
				"key"					=> $request->key,
				"url" 				=> $this->getUrl(),
				"surl" 				=> route('payuRes', ['success', $request->txnid]),
				"furl" 				=> route('payuRes', ['failure', $request->txnid]),
				"name" 				=> $request->name,
				"hash" 				=> $request->hash,
				"phone" 			=> $request->phone,
				"email" 			=> $request->email,
				"amount" 			=> $request->amount,
				"hashseq" 		=> $request->hashseq,
				"productinfo" => $request->productinfo,
			];

		return view('common.payment.payumoney.index', $blade);
	}


	public function response($status, $txnid, Request $request)
	{
		$isSuccess = $this->statusBool($status);
		$payu = $this->model()->findByTxnidOrElse($txnid);
		$payu->is_success = $isSuccess;
		$payu->save();
		$blade = [
					"url" => $payu->backUrl($isSuccess),
					"payuid" =>$payu->id,
				];
		return view('common.payment.payumoney.back', $blade);
	}


	public function store(Request $request)
	{
		$payu = $this->model();
		$payu->txnid = $request->txnid;
		$payu->payable_id = $request->payable_id;
		$payu->payable_type = $request->payable_type;
		$payu->amount = $request->amount;
		$payu->net_amount = $request->net_amount;
		$payu->request = $request->all();
		$payu->surl = $request->surl;
		$payu->furl = $request->furl;
		$payu->save();
		return $payu;
	}


	public function checkData($data)
	{
		$validator = \Validator::make($data, [
			"payable_id"	=> "required|numeric",
			"payable_type"=> "required",
			"key" 				=> "required",
			"salt" 				=> "required",
			"surl" 				=> "required",
			"furl" 				=> "required",
			"name" 				=> "required",
			"phone" 			=> "required",
			"email" 			=> 'required|email',
			"amount" 			=> "required|regex:/^\d*(\.\d{1,4})?$/",
			"net_amount" 	=> "required|regex:/^\d*(\.\d{1,4})?$/",
			"productinfo" => "required",
		]);

		if ($validator->fails()) {
			return exitView();
		}

		return true;
	}


	public function getUrl()
	{
		return $this->mode == 'secure' ? $this->secureUrl : $this->testUrl;
	}


	public function statusBool($status)
	{
		$res = 0;

		if ($status == 'success') {
			$res = 1;
		}
		elseif ($status != 'failure') {
			wrongView();
		}

		return $res; 
	}

}
