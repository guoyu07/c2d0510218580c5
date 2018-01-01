<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminApp\TransectionModel;
use App\Traits\CallTrait;

class TransectionController extends Controller
{
	use CallTrait;


	public function model()
	{
		return new TransectionModel;
	}


	public function new($data)
	{
		$trans = $this->model();
		$trans->uid = $data->uid;

		if (isset($data->deposited)) {
			$trans->deposited = $data->deposited;
		}

		if (isset($data->withdrawn)) {
			$trans->withdrawn = $data->withdrawn;
		}

		$trans->conjoinly_id = $data->conjoinly_id;
		$trans->conjoinly_type = $data->conjoinly_type;
		$trans->is_success = $data->is_success;
		$trans->tran_type = $data->tran_type;
		$trans->save();
		return $trans;
	}


	public function show($txnid)
	{
		$result = $this->model()->findByUidOrExit($txnid);

		$blade = [
				"response" => $result->is_success ? 'successful' : 'failed',
				"balance" => $result->amount,
				"txnid" => $txnid,
			];

		return view('admin.protected.dashboard.pages.transection.show', $blade);
	}


}
