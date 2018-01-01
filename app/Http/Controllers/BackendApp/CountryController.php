<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonApp\CountryModel;
use App\Traits\CallTrait;

class CountryController extends Controller
{
	use CallTrait;
	
	protected $viewPath = 'backend.protected.dashboard.pages.countries';

	public function model(){
		return new CountryModel;
	}

	public function index(Request $request)
	{
		$countries = $this->model()
												->where([['country', 'like', '%'.$request->s.'%']])
													->simplePaginate(25);
		return view($this->viewPath.'.index', ['countries' => $countries]);
	}


	public function show($id)
	{
		$country = $this->model()->findOrFail($id);
		$blade = [
					"country" => $country
				];
		
		return view($this->viewPath.'.show', $blade);
	}

	public function edit($id)
	{
		$country = $this->model()->findOrFail($id);
		$blade = [
					"country" => $country
				];
		
		return view($this->viewPath.'.edit', $blade);
	}


	public function update($id, Request $request)
	{
		$country = $this->model()->findOrFail($id);
		$blade = [
					"country" => $country
				];
		
		return view($this->viewPath.'.edit', $blade);
	}

	

	public function getCountry($country = ''){
		return $this->model()->getCountry($search);
	}

	public function all(){
		return CountryModel::select()->where(['status' => 'Active'])->get();
	}

}
