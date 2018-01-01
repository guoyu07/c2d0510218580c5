<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\FollowUpModel;
use App\Traits\CallTrait;

class FollowUpController extends Controller
{
	use CallTrait;

	public $viewPath = 'b2b.protected.dashboard.pages.follow_up';


	public function model()
	{
		return new FollowUpModel;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$fups = $this->model()->byUser()
						->byGtNow()->byIsActive()
							->bySearch($request->search)
								->simplePaginate(25);

		return view($this->viewPath.'.index', ["follow_ups" => $fups]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$res = [
					"status" => 200,
					"response" => "Something went wrong"
				];

		if ($request->pid) {
			$auth = auth()->user();
			$followUp = $this->model();
			$followUp->user_id = $auth->id;
			$followUp->package_id = $request->pid;
			$followUp->datetime = $request->datetime;
			$followUp->note = $request->followup;
			$followUp->save();
			$res['response'] = "saved successfully...";
		}

		return json_encode($res);
	}


	// ======this function to fatch all follow up from db======
	/*public function all()
	{
		$result = FollowUpModel::select()
							->with('package')
								->byUser()
									->byIsActive()
										->whereRaw("`datetime` > now()")
											->get();

		return $result;
	}*/


}
