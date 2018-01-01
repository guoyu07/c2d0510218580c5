<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UberApiController;
use App\Models\B2bApp\PacakgeCabModel;
use App\Traits\CallTrait;

class CabsController extends Controller
{
	use CallTrait;
	
  public function getAllCabs($packageDbId){
  	return (object)[];
  }


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

		return view('b2b.protected.dashboard.pages.cab.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
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
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
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

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}


	public function postProduct(Request $request)
	{
		// pre_echo($request->input());
		$result  = UberApiController::call()->getProduct($request);
		$blade = [
				"result" => $result,
			];

		return view('b2b.protected.dashboard.pages.cab.partials.content_result', $blade);
	}

	public function createNew($request)
	{
		$cab = new PacakgeCabModel;
		$cab->relation_id = $request->id;
		$cab->relation_table = $request->table;
		$cab->save();
		return $cab->id;
	}

	public function postBook(Request $request)
	{
		$result = UberApiController::call()->book($request);
		dd_pre_echo($result);
		$blade = [
				'result' => $result
			];

		return view('b2b.protected.dashboard.pages.cab.partials.content_book', $blade);
	}

	public function postPickUp(Request $request)
	{
		$result = UberApiController::call()->postRequestEstimate($request);

		$blade = [
				'result' => $result, 
				'index' => $request->index,
				'dbId' => $request->rowIndex, 
			];

		return view('b2b.protected.dashboard.pages.cab.partials.content_pickup', $blade);
	}

  
}
