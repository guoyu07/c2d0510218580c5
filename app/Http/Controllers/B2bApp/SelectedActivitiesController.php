<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\SelectedActivityModel;
use App\Traits\CallTrait;

class SelectedActivitiesController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new SelectedActivityModel;
	}

	public function inactiveOld($packageActivityId)
	{
		$this->model()
						->byPackageActivityId($packageActivityId)
							->update(['is_active' => 0]);
		return $this;
	}


	public function bulkInsert($data)
	{
		SelectedActivityModel::insert($data);
		
		return $this;
	}

}
