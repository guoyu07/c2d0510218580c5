<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminApp\TextModel;
use App\Traits\CallTrait;

class TextController extends Controller
{
	use CallTrait;
	public $viewPath = 'admin.protected.dashboard.pages.text';


	public function model()
	{
		return new TextModel;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$texts = $this->model()->byAdmin()
							->searchQuery($request->t)
								->orderBy("order","asc")->get();

		return view($this->viewPath.'.index', compact('texts')); 
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
				"title" => "required|max:255",
				"text" => "required"
			]);

		$this->createOrUpdate($request, $id);
		return redirect('dashboard/settings/text');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$text = $this->model()->byAdmin()->findOrFail($id);
		return view($this->viewPath.'.show', compact('text')); 
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$text = $this->model()->byAdmin()->findOrFail($id);
		return view($this->viewPath.'.create_edit', compact('text')); 

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
				"title" => "required|max:255",
				"text" => "required"
			]);

		$this->createOrUpdate($request, $id);

		return redirect('dashboard/settings/text');
	}

	/*
	| this function to activate 
	*/
	public function activate($id)
	{
		$text = $this->model()->byAdmin()->findOrFail($id);
		$text->is_active = 1;
		$text->save();
		return redirect('dashboard/settings/text');
	}



	/*
	| this function to deactivate
	*/
	public function deactivate($id)
	{
		$text = $this->model()->byAdmin()->findOrFail($id);
		$text->is_active = 0;
		$text->save();
		return redirect('dashboard/settings/text');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, Request $request)
	{
		$text = $this->model()->byAdmin()->findOrFail($id);
		$text->delete();
		return redirect('dashboard/settings/text');
	}



	public function createOrUpdate(Request $request, $id = null)
	{
		$text = $this->model()->byAdmin()->findOrFail($id);

		if (is_null($text)) {
			$text = $this->model();
		}

		$auth = auth()->guard('admin')->user();
		$text->admin_id = $auth->id;
		$text->title = $request->title;
		$text->text = $request->text;
		$text->save();

		return $text;
	}


}
