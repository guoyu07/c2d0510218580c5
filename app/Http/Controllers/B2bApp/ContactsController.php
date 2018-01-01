<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\ContactModel;
use App\Traits\CallTrait;


class ContactsController extends Controller
{
	use CallTrait;
	
	public $viewPath = 'b2b.protected.dashboard.pages.contact';


	public function model()
	{
		return new ContactModel;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(request $request)
	{
		$contacts = $this->model()->findContacts($request->s);
		return view($this->viewPath.'.index', ["contacts" => $contacts]);
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
			'title' => 'required|max:255',
			'fullname' => 'required|max:255',
			'phone' => 'numeric',
			'email' => 'email|max:255',
			'image_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		$contact = new ContactModel;
		$contact->title = $request->title;
		$contact->fullname = $request->fullname;
		$contact->phone = $request->phone;
		$contact->email = $request->email;
		$contact->about = $request->about;
		$contact->address = $request->address;
		$contact->facebook = $request->facebook;
		$contact->googleplus = $request->googleplus;
		$contact->linkedin = $request->linkedin;
		$contact->twitter = $request->twitter;
		if (!is_null($request->profile_pic)) {
			$imageName = time().'.'.$request->profile_pic->getClientOriginalExtension();
			$request->profile_pic->move(public_path('images/contacts'), $imageName);
		}
		else{
			$imageName = 'temp_profile.jpg';
		}
		
		$contact->image_path = 'images/contacts/'.$imageName;
		$contact->status = 'active';
		$contact->save();
		session()->flash('success', 'Contact added successfully!');
		return redirect('dashboard/tools/contacts');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$auth = auth()->user();
		$contact = ContactModel::where([
						"status" => "active", 
						"user_id" => $auth->id
					])
				->find($id);
		
		return view($this->viewPath.'.show', ["contact" => $contact]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$auth = auth()->user();
		$contact = ContactModel::find($id);
		if (!is_null($contact) && $auth->id == $contact->user_id) {
			return view($this->viewPath.'.edit', ["contact" => $contact]);
		}
		else{
			return view('errors.404');
		}
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
			'title' => 'required|max:255',
			'fullname' => 'required|max:255',
			'phone' => 'numeric',
			'email' => 'email|max:255',
			'image_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		$contact = ContactModel::find($id);
		$contact->title = $request->title;
		$contact->fullname = $request->fullname;
		$contact->phone = $request->phone;
		$contact->email = $request->email;
		$contact->about = $request->about;
		$contact->address = $request->address;
		$contact->facebook = $request->facebook;
		$contact->googleplus = $request->googleplus;
		$contact->linkedin = $request->linkedin;
		$contact->twitter = $request->twitter;
		
		if ($request->profile_pic != null) {
			$imageName = time().'.'.$request->profile_pic->getClientOriginalExtension();
			$request->profile_pic->move(public_path('images/contacts'), $imageName);
			$contact->image_path = 'images/contacts/'.$imageName;
		};
		
		
		$contact->status = 'active';

		$contact->save();

		session()->flash('success', 'Contact updated successfully!');

		return redirect('dashboard/tools/contacts/'.$contact->id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$contact = ContactModel::find($id);
		$contact->status = 'inactive';
		$contact->save();

		session()->flash('danger', 'Contact Deleted.');

		return redirect('dashboard/tools/contacts');
	}
}
