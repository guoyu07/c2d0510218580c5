<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\B2bApp\ClientController;

class EnquiryController extends ClientController
{
	public $viewPath = 'b2b.protected.dashboard.pages.enquiry';

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$clients = $this->model()->byUser()->byNotStatus()
							->searchName($request->search)->simplePaginate(20);

		return view($this->viewPath.'.index', compact('clients'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view($this->viewPath.'.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'vendor' => 'required|numeric',
			'fullname' => 'required|max:255',
			'mobile' => 'required|numeric',
			'email' => 'required|email|max:255',
		]);


		$client = $this->model()->duplicateOrNew(
													$request->mobile, 
													$request->email
												);

		$auth = auth()->user();
		$client->user_id = $auth->id;
		$client->lead_vendor_id = $request->vendor;
		$client->fullname = $request->fullname;
		$client->mobile = $request->mobile;
		$client->email = $request->email;
		$client->save();

		return redirect($client->createRouteUrl());
	}

}
