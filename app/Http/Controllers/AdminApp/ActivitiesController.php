<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonApp\ImageController;
use App\Http\Controllers\CommonApp\CountryController;
use App\Http\Controllers\CommonApp\DestinationController;
use App\Http\Controllers\ActivityApp\AgentActivitiesController;
use App\Traits\CallTrait;


class ActivitiesController extends Controller
{
	use CallTrait;

	public $viewPath = 'admin.protected.dashboard.pages.activity';

	public function model()
	{
		return AgentActivitiesController::call()->model();
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$activities = $this->model()->byAdmin()
									->bySearch($request->search)
										->byDestinationCode($request->city)
											->orderBy('rank')
												->simplePaginate(20);

		$blade = ['activities' => $activities];

		if (isset($request->city)) {
			$destination = DestinationController::call()
										->model()->find($request->city);
			if (!is_null($destination)) {
				$blade['destination'] = $destination;
			}
		}
		
		return view($this->viewPath.'.index', $blade);
	}


	public function showLocation(Request $request)
	{
		$countries = $this->model()->byAdmin()
									->bySearch($request->search)
										->groupBy('destination_code')
											->simplePaginate(50)
												->groupBy('destination.country_code')
													->values();

		return view($this->viewPath.'.location', compact('countries'));
	}


	public function createOrEdit(Request $request, $id = null)
	{
		$activity = $this->model()->byAdmin()->find($id);

		if (is_null($activity)) {
			$activity = $this->model();
			$destination = DestinationController::call()
											->model()->find($request->city);
		}
		else{
			$destination = $activity->destination;
		}

		$query = isset($destination->id) 
					 ? http_build_query(['city' => $destination->id])
					 : '';

		$blade = [
				'destination' => $destination, 
				'activity' => $activity, 
				'query' => $query
			];

		return view($this->viewPath.'.create_edit', $blade);
	}


	public function storeOrUpdate(Request $request)
	{
		$activity = $this->model()->byAdmin()->find($request->id);

		if (is_null($activity)) $activity = $this->model();

		$activity->title =  $request->title;
		$activity->pick_up = $request->pick_up;
		$activity->duration = $request->duration;
		$activity->description =  $request->description;
		$activity->destination_code =  $request->dest_code;
		$activity->inclusion = $request->inclusion;
		$activity->exclusion = $request->exclusion;
		$activity->save();
		
		$images = isset($request->images) && is_array($request->images) 
						? $request->images
						: [];

		ImageController::call()->model()->makeAndSave(
				$images, $activity->id,
				'App\Models\ActivityApp\AgentActivityModel'		
			);

		if ($request->format == 'json') {
			return json_encode([
					"status" => 200,
					"response" => "saved successfully."
				]);
		}

		return $this->redirectIndex(['city' => $request->dest_code]);
	}



	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return redirect('dashboard/inventories/activity/store?city='.request()->city);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$activity = $this->model()->findOrFail($id);
		return view($this->viewPath.'.show', compact('activity'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		return redirect('dashboard/inventories/activity/store/'.$id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}


	public function storeOrUpdateRanks(Request $request)
	{
		if (is_array($request->ranks)) {
			foreach ($request->ranks as $key => $value) {
				if (isset($value['id']) && isset($value['rank'])) {
					$activity = $this->model()->find($value['id']);
					if (!is_null($activity)) {
						$activity->rank = $value['rank'];
						$activity->save();
					}
				}
			}
		}
		return json_encode(['status' => 200, 'response' => 'successfully']);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$activity = $this->model()->findOrFail($id);
		$city = $activity->destination_code;
		$activity->delete();
	
		return $this->redirectIndex(['city' => $city]);
	}


	public function destroyImage($id, $iid)
	{
		ImageController::call()->destroy($iid);
	
		return redirect()->back();
	}


	public function deactivate($id)
	{
		$activity = $this->model()->findOrFail($id);
		$city = $activity->destination_code;
		$activity->is_active = 0;
		$activity->save();

		return $this->redirectIndex(['city' => $city]);
	}


	public function activate($id)
	{
		$activity = $this->model()->findOrFail($id);
		$city = $activity->destination_code;
		$activity->is_active = 1;
		$activity->save();

		return $this->redirectIndex(['city' => $city]);
	}


	public function changeStatus($id, $status)
	{
		$activity = $this->model()->findOrFail($id);
		$activity->is_active = $status;
		$activity->save();
		return $this;
	}

	public function redirectIndex(Array $params = [])
	{
		return redirect(url('dashboard/inventories/activity').'?'.http_build_query($params));
	}





}
