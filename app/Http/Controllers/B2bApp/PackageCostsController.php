<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\PackageCostModel;
use App\Traits\CallTrait;

class PackageCostsController extends Controller
{
	use CallTrait;
	
	protected $packageId = '';

	public function model()
	{
		return new PackageCostModel;
	}

	public function createNew($pid, $request)
	{
		$this->packageId = $pid;
		
		$isVisa = isset($request->isVisa) ? $request->isVisa : 0;
		$packageCost = $this->lastCost();
		$check = (
						!is_null($packageCost) &&
						$packageCost->is_visa == $isVisa &&
						$packageCost->margin	== $request->margin &&
						$packageCost->net_cost == $request->netCost &&
						$packageCost->currency == $request->currency &&
						$packageCost->visa_cost == $request->visaCost
					);

		if (!$check) {
			$this->inactiveByPackageId();
			$packageCost = $this->model();
			$packageCost->package_id = $this->packageId;
			$packageCost->is_visa = $isVisa;
			$packageCost->currency = $request->currency;
			$packageCost->visa_cost = $request->visaCost;
			$packageCost->net_cost = $request->netCost;
			$packageCost->margin = $request->margin;
			$packageCost->save();
		}

		return $packageCost;
	}

	public function inactiveByPackageId()
	{
		$this->model()
					->where(['package_id' => $this->packageId])
						->update(['is_current' => 0]);
		return $this;
	}

	public function lastCost()
	{
		return $this->model()
									->where([
												"package_id" => $this->packageId,
												"is_current" => 1
											])
										->first();
	}

}
