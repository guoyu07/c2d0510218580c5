<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminApp\TextController;
use App\Http\Controllers\CommonApp\ImageController;

class ProfileController extends Controller
{

	public $viewPath = 'admin.protected.dashboard.pages.profile';


	public function index()
	{
		return view($this->viewPath.'.index');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit()
	{
		// $admin = auth()->guard('admin')->user();
		// dd($admin->profile_pic);
		return view($this->viewPath.'.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$admin = auth()->guard('admin')->user();
		$admin->prefix = $request->prefix;
		$admin->firstname = $request->firstname;
		$admin->lastname = $request->lastname;
		$admin->companyname = $request->companyname;
		$admin->mobile = $request->mobile;
		$admin->email = $request->email;
		$admin->address = $request->address;
		$admin->website = $request->website;

		$text = TextController::call()->createOrUpdate(
											new Request([
												'title' => 'About', 
												'text' => $request->about
											]), 
											$admin->text_about_id
										);

		if (strlen($request->profile_path) > 3) {
			$profile = ImageController::call()->createOrUpdate(
										new Request([
												'type' => 'path',
												'image_path' => $request->profile_path, 
												'caption' => 'Admin Profile Image',
												'connectable_id' => $admin->id,
												'connectable_type' => 'App\\Admin'
											]),
										$admin->image_profile_id
									);
			$admin->image_profile_id = $profile->id;
		}

		if (strlen($request->logo_path) > 3) {
			$logo = ImageController::call()->createOrUpdate(
									new Request([
											'type' => 'path',
											'image_path' => $request->logo_path, 
											'caption' => 'Admin Logo Image',
											'connectable_id' => $admin->id,
											'connectable_type' => 'App\\Admin'
										]),
									$admin->image_logo_id
								);
			$admin->image_logo_id = $logo->id;
		}
		
		$admin->text_about_id = $text->id;
		$admin->save();
	

		if (strtolower($request->format) == 'json') {
			return json_encode([
									"status" => 200,
									"response" => 'saved successfully'
								]);
		}
		else {
			return redirect('dashboard/profile');
		}

	}

}
