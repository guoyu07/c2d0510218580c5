<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonApp\DestinationModel;
use App\Traits\CallTrait;

class DestinationController extends Controller
{
	use CallTrait;

	protected $viewPath = 'backend.protected.dashboard.pages.destinations';

	public function model(){
		return new DestinationModel;
	}


	public function index(Request $request)
	{
		$dests = $this->model()
										->where([['destination', 'like', '%'.$request->s.'%']])
											->simplePaginate(25);
											
		return view($this->viewPath.'.index', ['destinations' => $dests]);
	}

	public function getDestination(Request $request)
	{
		$result = $this->model()->searchName($request->term);
		
		$location = [];		
		foreach ($result as $key => $value) {
			$location[] = $value->location; 
		}

		return json_encode($location);
	}

	public function postDestination(Request $request, $json = true){
		$destinations = $this->findByCountryCode($request->countryCode, ['destination', 'fgf_destinationcode']);

		return $json ? json_encode($destinations) : $destinations;
	}

	public function postDestinationOption(Request $request){

		$destinations = $this->postDestination($request, false);
		$htmlOption = '';
		if ($destinations->count() > 0) {
			foreach ($destinations as $destination) {
				$htmlOption .= '<option value="'.$destination->fgf_destinationcode.'">'.$destination->destination.'</option>';
			}
		}
		return $htmlOption;
	}

	public function findByCountryCode($fgf_countrycode, $column = '*'){
		$result = DestinationModel::select($column)
																->where(['fgf_countrycode' => $fgf_countrycode])
																	->get();
		return $result; 
	}


	public function search($word)
	{
		return $this->model()->search($word);
	}


	public function findByDestination($word)
	{
		return $this->model()->findByDestination($word);
	}


}
