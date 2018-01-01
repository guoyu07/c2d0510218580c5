<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\ProfileModel;
use Hash;

class ProfileController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('b2b.protected.dashboard.pages.profile.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('b2b.protected.dashboard.pages.contact.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('dashboard/profile');

		/*$userdetail = userdetail();
		return view('b2b.protected.dashboard.pages.contact.show', ["contact" => $userdetail]);*/
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($user)
	{
		return view('b2b.protected.dashboard.pages.profile.edit');
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
			'firstname' => 'required|max:255',
			'lastname' => 'required|max:255',
			'mobile' => 'numeric',
			'email' => 'email|max:255',
			'image_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		$user = auth()->user();

		$userDb = ProfileModel::find($user->id);
		$userDb->firstname = $request->firstname;
		$userDb->lastname = $request->lastname;
		$userDb->mobile = $request->mobile;
		$userDb->email = $request->email;
		$userDb->about = $request->about;
		$userDb->address = $request->address;
		$userDb->facebook = $request->facebook;
		$userDb->googleplus = $request->googleplus;
		$userDb->linkedin = $request->linkedin;
		$userDb->twitter = $request->twitter;

		if (!is_null($request->profile_pic)) 
			$userDb->image_path = imageUpload($request->profile_pic);
		else
			$userDb->image_path = 'images/default/profile.jpg';

		$userDb->save();

		session()->flash('success', 'Contact updated successfully!');

		return redirect('dashboard/profile');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$user = ContactModel::find($id);
		$user->status = 'Inactive';
		$user->save();

		session()->flash('danger', 'Contact Deleted.');

		return redirect('dashboard/tools/contacts');
	}


	public function getPassword(){
		return view('b2b.protected.dashboard.pages.profile.password');
	}


	public function putPassword(Request $request)
	{

		$this->validate($request, [
			'oldPassword' => 'required|min:6',
			'password' => 'required|min:6|confirmed',
		]);

		$user = auth()->user();

		if (Hash::check($request->oldPassword, $user->password)) {
			$userDb = ProfileModel::find($user->id);
			$userDb->password = bcrypt($request->password);
			$userDb->save();
			session()->flash('success', 'Password updated successfully!');
			return redirect('dashboard/profile');
		}
		else{
			session()->flash('danger', 'Old password not match.');
			return back();
		}


	}



}
