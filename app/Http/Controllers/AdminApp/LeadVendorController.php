<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonApp\ImageController;
use App\Models\AdminApp\LeadVendorModel;
use App\Traits\CallTrait;

class LeadVendorController extends Controller
{
	use CallTrait;

	public $viewPath = 'admin.protected.dashboard.pages.lead_vendor';

	public function model()
	{
		return new LeadVendorModel;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$vendors = $this->model()->byAdmin()
								->search($request->v)
									->simplePaginate(6);

		return view($this->viewPath.'.index', compact('vendors')); 
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
		$this->createOrUpdate($request);
		session()->flash('success', 'Vendor added successfully!');
		return redirect('dashboard/settings/vendor/lead');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$vendor = $this->model()->byAdmin()->findOrFail($id);
		return view($this->viewPath.'.show', compact('vendor')); 
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$vendor = $this->model()->byAdmin()->findOrFail($id);
		return view($this->viewPath.'.create_edit', compact('vendor'));
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
		$this->createOrUpdate($request, $id);
		session()->flash('success', 'Vendor updated successfully!');
		return redirect('dashboard/settings/vendor/lead');
	}


	/*
	| this function to active vendor
	*/
	public function activate($id)
	{
		$vendor = $this->model()->byAdmin()->findOrFail($id);
		$vendor->is_active = 1;
		$vendor->save();
		return redirect('dashboard/settings/vendor/lead');
	}

	public function deactivate($id)
	{
		$vendor = $this->model()->byAdmin()->findOrFail($id);
		$vendor->is_active = 0;
		$vendor->save();
		return redirect('dashboard/settings/vendor/lead');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$vendor = $this->model()->unlockOnly()
											->byAdmin()->findOrFail($id);
		$vendor->updateVendorId()->delete();
		return redirect('dashboard/settings/vendor/lead');
	}


	public function createOrUpdate(Request $request, $id = null)
	{
		$this->validate($request, [
			'company_name' => 'required|max:255',
			'contact_person' => 'required|max:255',
			'contact_number' => 'numeric',
			'email_id' => 'email|max:255',
			'image_path' => 'min:6',
		]);

		$leadVendor = !is_null($id)
								? $this->model()->byAdmin()->find($id)
								: null;

		if (is_null($leadVendor)) {
			$leadVendor = $this->model();
		}

		$auth  = auth()->guard('admin')->user();

		$leadVendor->admin_id = $auth->id;
		$leadVendor->company_name = $request->company_name;
		$leadVendor->contact_person = $request->contact_person;
		$leadVendor->contact_number = $request->contact_number;
		$leadVendor->email_id = $request->email_id;
		$leadVendor->address = $request->address;
		$leadVendor->website = $request->website;
		$leadVendor->note = $request->note;
		$leadVendor->save();

		if (strlen($request->image_path) > 3) {
			$image = ImageController::call()->createOrUpdate(
									new Request([
											'type' => 'path',
											'image_path' => $request->image_path, 
											'caption' => 'Admin Profile Image',
											'connectable_id' => $leadVendor->id,
											'connectable_type' => LeadVendorModel::class
										]),
									$leadVendor->image_id
								);

			$leadVendor->image_id = $image->id;
		}

		$leadVendor->save();
		return $leadVendor;
	}

}
