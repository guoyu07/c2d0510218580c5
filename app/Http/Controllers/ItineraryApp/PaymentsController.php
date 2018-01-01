<?php

namespace App\Http\Controllers\ItineraryApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ItineraryApp\PaymentModel;
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\CommonApp\PayuPaymentsController;
use App\Traits\CallTrait;
use Carbon\Carbon;

class PaymentsController extends Controller
{
	use CallTrait;
	
	public function model()
	{
		return new PaymentModel;
	}	


	public function payNow($token, Request $request)
	{
		$validator = \Validator::make($request->all(), [
      'name' => 'required|max:255',
			'email' => 'required|email|max:255',
			'mobile' => 'required|max:255',
			'date' => 'required|date_format:d/m/Y',
			'pax' => 'required|max:255|numeric',
			'amount' => 'required|regex:/^\d*(\.\d{1,4})?$/',
    ]);

    if ($validator->fails()) {
    	return wrongView();
    }

		$package = PackageController::call()->model()
								->byToken($token)->firstOrFail();

		$date = is_null($request->date) 
					? Carbon::now()
					: Carbon::createFromFormat('d/m/Y', $request->date);

		$payment = $this->model();
		$payment->token = new_token();
		$payment->package_id = $package->id;
		$payment->name =  $request->name;
		$payment->email =  $request->email;
		$payment->mobile =  $request->mobile;
		$payment->date =  $date->toDateString();
		$payment->pax =  $request->pax;
		$payment->amount = $request->amount;
		$payment->back_url = $request->back;
		$payment->save();

		$data = [
			"payable_id"	=> $payment->id,
			"payable_type"=> "App\\Models\\ItineraryApp\\PaymentModel",
			"key" 				=> $package->user->admin->payu_key,
			"salt" 				=> $package->user->admin->payu_salt,
			"surl" 				=> route('payStatusUrl', ['success', $payment->token]),
			"furl" 				=> route('payStatusUrl', ['failure', $payment->token]),
			"name" 				=> $request->name,
			"phone" 			=> $request->mobile,
			"email" 			=> $request->email,
			"amount" 			=> add_percent($request->amount, 2.9),
			"net_amount" 	=> $request->amount,
			"productinfo" => 'Brought package',
		];

		$newPayu = new PayuPaymentsController;
		
		/* // for test
		$data["key"] = env('TEST_PAYUMONEY_KEY');
		$data["salt"] = env('TEST_PAYUMONEY_SALT');
		$newPayu->mode = 'test';*/
		
		return $newPayu->index($data);
	}


	public function response($status, $token, Request $request)
	{
		$statusBool = status_bool($status);
		$payment = $this->model()->byToken($token)->firstOrFail();
		$blade = [
							'name' => $payment->name,
							'email' => $payment->email,
							'txnid' => $payment->txnid,
							'is_success' => $statusBool,
							'redirect_to' => $payment->back_url
						];

		return view('subway.pages.payment-status', $blade);

		// return redirect($payment->back_url);
	}


}
