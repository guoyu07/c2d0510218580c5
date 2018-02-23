<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\VoucherModel;
use App\Models\B2bApp\VoucherServiceModel;
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

		$blade = [
					'data' => $voucher,
					'isCreate' => 0,
				];
		return view($this->viewPath.'.show', $blade);
	}


	public function showPDF($token)
	{
		$voucher = VoucherServiceModel::byToken($token)->firstOrFail();
		// dd($voucher->accommodation_details->star_rating);
		$html = view($this->viewPath.'.html.new_voucher', ['data' => $voucher])->render();
		// return $html;
		return PdfController::call()->createPdf($voucher->uid, $html);
	}

	public function showTestPDF()
	{
		$html = view('test.voucher')->render();
		// return $html;

		return PdfController::call()->createPdf('pdf', $html);
	}


	public function create()
	{
		return view($this->viewPath.'.create', ['isCreate' => 1]);
	}


	public function createAndShow($token='')
	{
		$voucher = [];
		$isCreate = 1;

		if (strlen($token) > 10) {
			$voucher =  $this->model()->byToken($token)->firstOrFail();
			// dd($voucher->voucherServices->pluck('built_data', 'token'));
			$isCreate = 0;
		}

		$blade = [
					'data' => $voucher,
					'isCreate' => $isCreate,
				];

		return view($this->viewPath.'.create', $blade);
	}


	public function postClientAdd(Request $request)
	{
		$token = null;

		if (is_null($request->ctoken)) {
			$client = new ClientModel;
			$client->fullname = $request->name;
			$client->mobile = $request->mobile;
			$client->email = $request->email;
			$client->save();
			$token = $client->token;
		}

		return json_encode(['token' => $token]);
	}

	public function postStoreData(Request $request)
	{
		$voucher = $this->model()->byToken($request->vtoken)->first();
		
		if (is_null($voucher)) {
			$client = ClientModel::byToken($request->ctoken)->firstOrFail();
			$voucher = $this->model();
			$voucher->client_id = $client->id;
			$voucher->save();
		}

		$service = $request->all();

		// foreach ($request->services as $service) {
		$voucherService = VoucherServiceModel::byToken($request->vstoken)
												->first();

		if (is_null($voucherService)) {
			$voucherService = new VoucherServiceModel;
		}
		
		$voucherService->type = array_get($service, 'type');
		$voucherService->voucher_id = $voucher->id;
		$voucherService->destination_id = array_get($service, 'dest_id');
		$voucherService->check_in = Carbon::createFromFormat('d/m/Y', 
																array_get($service, 'check_in'))->format('Y-m-d');
		$voucherService->check_out = Carbon::createFromFormat('d/m/Y', 
																array_get($service, 'check_out'))->format('Y-m-d');
		$voucherService->terms = array_get($service, 'terms');
		$voucherService->remark = array_get($service, 'remark');
		$voucherService->guests = array_get($service, 'guests');
		$voucherService->data = array_get($service, 'data');
		$voucherService->save();
		// }


		return json_encode([
						'vtoken' => $voucher->token, 
						'vstoken' => $voucherService->token
					]);
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


	public function postShowAccommodationProperties(Request $request)
	{
		$request->validate([
				'vendor' => 'required',
				'id' => 'required'
			]);

		$props = HotelsController::call()->hotelRooms($request->all());
		$props = array_get($props, 'rooms');
		return json_encode($props);
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
