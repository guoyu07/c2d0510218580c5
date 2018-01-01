<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BackendApp\PlansController;
use App\Http\Controllers\AdminApp\TransectionController;
use App\Models\AdminApp\PackageModel;
use App\Traits\CallTrait;
use Carbon\Carbon;

class PackageController extends Controller
{
	use CallTrait;
	protected $viewPath = 'admin.protected.dashboard.pages.package';

	public function model()
	{
		return new PackageModel; 
	}


	public function getShowPlans()
	{
		$plans = PlansController::call()->model()->all();
		$viewPath = 'admin.protected.dashboard.pages.plans';
		$blade = [
				'viewPath' => $viewPath,
				'plans' => $plans
			];
		return view($viewPath.'.index', $blade);
	}


	public function getCheckout(Request $request)
	{
		$auth = auth()->guard('admin')->user();
		$plan = PlansController::call()->model()->find($request->plan);
		$viewPath = 'admin.protected.dashboard.pages.checkout';
		
		$blade = [
				'viewPath' => $viewPath,
				'plan' => $plan,
				'product' => $plan->name,
				'txnid' => uid(),
				'balance' => $auth->balance,
			];

		if ($plan->with_price) {
			$blade['price'] = round($plan->price, 2);
			$blade['tax'] = round($plan->tax, 2);
			$duration = daysToMonth($plan->duration);
			$duration = $duration > 12 ? 12 : $duration;
			$duration .= $duration > 1 ? ' Months' : ' Month';
			$blade['duration'] = $duration;
		}
		else {
			$blade['price'] = $request->amount;
			$blade['tax'] = round($request->amount*.15, 2);
			$blade['duration'] = 'Unlimited';
		}
		
		// $blade['payumoney'] = round(($blade['price']+$blade['tax'])*.029, 2);
		$blade['total'] = $blade['price']+$blade['tax'];
		// $blade['total'] += $blade['payumoney'];

		$tempCost = $blade['price']+$blade['tax']-$blade['balance'];
		$tempPayu = round($tempCost*.029, 2);
		$blade['payable'] = $tempCost+$tempPayu;
		return view($viewPath.'.index', $blade);
	}


	public function showInvoice($txnid)
	{
		$blade = [
				"productinfo" => $request->productinfo,
				"txnid" => $request->txnid,
				"name" => $request->firstname,
				"paymentId" => $request->encryptedPaymentId,
				"amount" => $request->amount,
				"addedon" => $request->addedon
			];
		return view('admin.protected.dashboard.pages.payumoney.success', $blade);
	}


	public function activatePlan($planId)
	{
		$auth = auth()->guard('admin')->user();
		if ($auth->isPackageActive()) {
			return $this->alreadyPackageActive();
		}

		$plan = PlansController::call()->model()->findOrFail($planId);
		$totalPrice = $plan->total;

		if ($totalPrice <= $auth->balance) {
			$now = Carbon::now();
			$end = Carbon::now();
			$end->addDays($plan->duration);
			$txnid = uid();
			$package = $this->model();
			$package->admin_id = $auth->id;
			$package->plan_id = $planId;
			$package->start_date = $now->format('Y-m-d');
			$package->end_date = $end->format('Y-m-d');
			$package->save();

			// new Transection 
			$trans = (object) [
					'uid' => $txnid,
					'plan_id' => $planId,
					'withdrawn' => $totalPrice,
					'is_success' => 1,
					'tran_type' => 'withdrawn',
					'conjoinly_id' => $package->id,
					'conjoinly_type' => 'App\\Models\\AdminApp\\PackageModel'
				];

			TransectionController::call()->new($trans);

			$auth->package_id = $package->id;
			$auth->balance = $auth->balance - $totalPrice;
			$auth->save();
			
			$blade = [
					"balance" => $auth->balance,
					"txnid" => $txnid
				];
			return view($this->viewPath.'.activated', $blade);
		}
		else {
			$need = $totalPrice - $auth->balance;
			return redirect()->route('addMoney', ['m' => $need]);
		}
	}



	public function alreadyPackageActive()
	{
		return view($this->viewPath.'.already_active');
	}


}
