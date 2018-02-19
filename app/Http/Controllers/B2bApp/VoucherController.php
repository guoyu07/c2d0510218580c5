<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\VoucherModel;
use App\Models\B2bApp\ClientModel;
use App\Http\Controllers\B2bApp\PdfController;
use App\Http\Controllers\HotelApp\HotelsController;
use App\Http\Controllers\B2bApp\ActivitiesController;
use App\Http\Controllers\CommonApp\DestinationController;

class VoucherController extends Controller
{
	protected $viewPath = 'b2b.protected.dashboard.pages.voucher';


	public function model()
	{
		return new VoucherModel;
	}


	public function index(Request $request)
	{
		$vouchers = $this->model()->byUser()->simplePaginate(25);
		return view($this->viewPath.'.index', ['vouchers' => $vouchers]);
	}


	public function show($token)
	{
		$voucher = $this->model()->byToken($token)->firstOrFail();
		return view($this->viewPath.'.html.voucher', ['data' => $voucher]);
	}


	public function showPDF($token)
	{
		$voucher = $this->model()->byToken($token)->firstOrFail();
		$html = view($this->viewPath.'.html.voucher', ['data' => $voucher])->render();
		return PdfController::call()->createPdf($voucher->uid, $html);
	}


	public function postStoreData(Request $request)
	{

		$client = ClientModel::byToken($request->ctoken)->firstOrFail();

		$newModel = $this->model();
		$newModel->type = $request->type;
		$newModel->user_id = auth()->user()->id;
		$newModel->client_id = $client->id;
		$newModel->destination_id = $request->dest_id;
		$newModel->check_in = Carbon::createFromFormat('d/m/Y', 
													$request->check_in)->format('Y-m-d');
		$newModel->check_out = Carbon::createFromFormat('d/m/Y', 
													$request->check_out)->format('Y-m-d');
		$newModel->terms = $request->terms;
		$newModel->remark = $request->remark;
		$newModel->guests = $request->guests;
		$newModel->data = $request->data;
		$newModel->save();

		return ['token' => $newModel->token];
	}


	public function showAccommodationVoucher($token){

	}


	public function createAccommodationVoucher()
	{
		return view($this->viewPath.'.accommodation');
	}


	public function postShowAccommodation(Request $request)
	{
		$request->validate([
				"term" => "required|min:4",
				"dest_id" => "required",
			]);

		$dest = DestinationController::call()->model()->find($request->dest_id);
		$hotels = [];
		if (!is_null($dest)) {
			$params = [
					'name' => $request->term,
					'latitude' => $dest->latitude,
					'longitude' => $dest->longitude,
				];

			$hotels = HotelsController::call()->hotels($params);
		}

		return json_encode($hotels);
	}


	public function postClientInfo(Request $request)
	{
		$request->validate([
				"term" => "required|min:4"
			]);

		$info =  ClientModel::byMobileSearch($request->term)
													->get()->pluck('built_data')->toJson();
		return $info;			
	}


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
