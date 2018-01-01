<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\ChildAgeModel;
use App\Traits\CallTrait;

class ChildAgeController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new ChildAgeModel;
	}	

	/* 
	don't use this function use call()->model()->insert();
	| this function is for bulk insert
	|	$data = [
	|			['room_guest_id' => 3, 'age'=> 3],
	|			['room_guest_id' => 3, 'age'=> 4],
	|		];
	public function bulkInsert($params)
	{
		$result = ChildAgeModel::insert($params);
	}*/

	public function createOrUpdate($id, Request $request)
	{
		$childAge = $this->model()->find($id);

		if (is_null($childAge)) {
			$childAge = $this->model();
		}

		$childAge->room_guest_id = $request->room_guest_id;
		$childAge->age = $request->age;
		$childAge->save();

		return $childAge;
	}

}
