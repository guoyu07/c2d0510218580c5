<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminApp\LeadVendorController;
use App\Models\B2bApp\ClientModel;
use App\Traits\CallTrait;

class EnquiryController extends Controller
{
	use CallTrait;

	public $viewPath = 'admin.protected.dashboard.pages.enquiry';


	public function model()
	{
		return new ClientModel;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$clients = $this->model()
							->byAdmin(1)->byNotStatus()
								->searchName($request->search)
									->orderBy('created_at', 'desc')
										->simplePaginate(20);

		return view($this->viewPath.'.index', compact('clients'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view($this->viewPath.'.create_edit');
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
			'vendor' => 'required',
			'agent' => 'required|numeric',
			'fullname' => 'required|max:255',
			'mobile' => 'required|numeric',
			'email' => 'required|email|max:255',
		]);


		$client = new ClientModel;
		$client->user_id = $request->agent;
		$client->lead_vendor_id = $request->vendor;
		$client->fullname = $request->fullname;
		$client->mobile = $request->mobile;
		$client->email = $request->email;
		$client->note = $request->note;
		$client->status = 3;
		$client->save();

		return redirect('dashboard/enquiry');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$enquiry = $this->model()->byAdmin(true)->findOrFail($id);
		return view($this->viewPath.'.show', compact('enquiry'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$enquiry = $this->model()->byAdmin(true)->findOrFail($id);
		return view($this->viewPath.'.create_edit', compact('enquiry'));
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
		$this->validate($request, [
			'vendor' => 'required',
			'agent' => 'required|numeric',
			'fullname' => 'required|max:255',
			'mobile' => 'required|numeric',
			'email' => 'required|email|max:255',
		]);

		$client = $this->model()->find($id);
		$client->user_id = $request->agent;
		$client->lead_vendor_id = $request->vendor;
		$client->fullname = $request->fullname;
		$client->mobile = $request->mobile;
		$client->email = $request->email;
		$client->note = $request->note;
		$client->status = 3;
		$client->save();

		return redirect('dashboard/enquiry');
	}

	public function active($id)
	{
		$enquiry = $this->model()->find($id);
		$enquiry->status = 1;
		$enquiry->save();
		return redirect('dashboard/enquiry');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, Request $request)
	{
		$enquiry = $this->model()->find($id);

		if (isset($request->inactive)) {
			$enquiry->status = 0;
		}
		// elseif(isset($request->delete)){
		// 	$enquiry->status = 'deleted';
		// }

		$enquiry->save();
		return redirect('dashboard/enquiry');
	}
}
