<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\ClientModel;
use App\Models\B2bApp\ClientAliasModel;
use App\Traits\CallTrait;

/*
| This Controller made of checking client is valid or not
| Client is attending assign user or not 
*/

class ClientController extends Controller
{
	use CallTrait;

	public function model(){
		return new ClientModel;
	}

	public function aliasModel()
	{
		return new ClientAliasModel;
	}


	public function activeClient($id)
	{
  	return $this->model()
									->where(['id' => $id])
										->update(['status' => 1]);

	}


	public function pending()
	{
		$clients = [];
		$data = $this->model()->byUser()->byStatus(3)->get();
		foreach ($data as $value) {
			$clients[] = [
					"uid" => $value->uid,
					"note" => $value->note,
					"token" => $value->token,
					"mobile" => $value->mobile,
					"fullname" => $value->fullname,
					"assign_to" => $value->assign_to,
					"created_at" => $value->created_at->format('Y-d-m'),
				];
		}
		return json_encode($clients);
	}



}
