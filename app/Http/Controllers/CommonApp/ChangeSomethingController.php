<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\ChangeSomethingModel;
use App\Traits\CallTrait;

class ChangeSomethingController extends Controller
{
	use CallTrait;

	public function index()
	{

		$changeSomething = new ChangeSomethingModel;
		$changeSomething->detail = 'Copying All id as hash in hash_id column in pdf_htmls table';

		if (!env('IS_LOCALHOST')) {
			PdfHtmlController::call()->copyIdasHashPdfHtmls();
		}

		$changeSomething->save();
		$changeSomething->stack_id = $changeSomething->id;
		$changeSomething->save();
	}

	public function once()
	{
		
	}

	// public function onceDone()
	// {
	// 	$stackId = 2;
	// 	$changeSomething = ChangeSomethingModel::select()
	// 										->where(['stack_id' => $stackId])
	// 											->first();

	// 	if (is_null($changeSomething)) {
	// 		$changeSomething = new ChangeSomethingModel;
	// 		$changeSomething->stack_id = $stackId;
	// 		$changeSomething->detail = 'have to delete total_cost column in packages table and all data must copy into package_costs table';

	// 		if (!env('IS_LOCALHOST')) {
	// 			PackageController::call()->dbCostSapr();
	// 		}

	// 		$changeSomething->save();
	// 	}
		
	// }


}
