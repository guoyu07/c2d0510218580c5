<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\B2bApp\PdfController;
use App\Http\Controllers\B2bApp\ActivitiesController;


class VoucherController extends Controller
{
	protected $viewPath = 'b2b.protected.dashboard.pages.voucher';

	public function getVouchers($type,Request $request)
	{
		if ($type == 'self') {
			return $this->selfVoucher();
		}
		elseif ($type == 'activity') {
			return $this->activity($request);
		}
		else{
			return exitView();
		}
	}

	public function selfVoucher()
	{
		return view($this->viewPath.'.self');
	}


	public function activity(Request $request)
	{
		$activity = ActivitiesController::call()->model()
								->byToken($request->tk)->firstOrFail();

		return $this->activityVoucherHtml($activity->voucherData());
	}



	public function activityVoucherHtml($data)
	{
		if (isset($data->companyName) && !is_null($data->companyName)) {
			$blade = ['data' => $data];
			$view = view($this->viewPath.'.html.activity', $blade);
			return PdfController::call()->createPdf('activity', $view);
		}
		else{
			exitView();
		}
	}

}
