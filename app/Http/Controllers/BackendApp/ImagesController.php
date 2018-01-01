<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonApp\ImageModel;
use App\Models\CommonApp\CountryModel;
use App\Models\CommonApp\DestinationModel;
use App\Traits\CallTrait;



class ImagesController extends Controller
{
	use CallTrait;

	public $viewPath = 'backend.protected.dashboard.pages.images';

	public function model(){
		return new ImageModel; 
	}

	
	public function upload(Request $request)
	{
		return \App\Http\Controllers\CommonApp\ImageController::call()->upload($request);
		// $imagePath = imageUpload($request->file);
		// return ['path' => $imagePath, 'host' => urlimage()];
	}



	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index()
	{
		return view($this->viewPath.'.index');
	}

	

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($type, $pid, Request $request)
	{
		$title = '';

		if ($type == 'country') {
			$country = CountryModel::findOrFail($pid);
			$images = $country->images;
			$title = 'Country : '.$country->country;
		}
		elseif ($type == 'destination') {
			$destination = DestinationModel::findOrFail($pid);
			$images = $destination->images;
			$title = 'Destination : '
								.$destination->country.', '
									.$destination->destination;
		}

		$blade = [
					"type" => $type,
					"title" => $title,
					"viewPath" => $this->viewPath,
					"url" => url('dashboard/manage/images/'.$type.'/'.$pid)
				];

		return view($this->viewPath.'.create', $blade);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store($type, $pid, Request $request)
	{
		$model = $this->getModelName($type);

		$data = [];

		foreach ($request->images as $image) {
			$image = (object) $image;
			if ($image->path != '') {
				$data[] = addDateColumns([
						"type" => "path",
						"image_path" => $image->path,
						"caption" => '',
						"connectable_id" => $pid,
						"connectable_type" => $model
					]);
			}
		}

		$this->model()->insert($data);
		return url('dashboard/manage/images/'.$type.'/'.$pid);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($type, $pid)
	{
		$images = [];
		
		if ($type == 'country') {
			$country = CountryModel::findOrFail($pid);
			$images = $country->images;
		}
		elseif ($type == 'destination') {
			$destination = DestinationModel::findOrFail($pid);
			$images = $destination->images;
		}

		$blade = [
					"type" => $type,
					"images" => $images->where('is_active', 1),
					"viewPath" => $this->viewPath
				];

		return view($this->viewPath.'.show', $blade);
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
	public function destroy($type, $pid, $id)
	{
		$this->model()->where('id', $id)->update(['is_active' => 0]);
		return redirect('dashboard/manage/images/'.$type.'/'.$pid);
	}


	public function getModelName($name)
	{
		$models = collect([
				'country' => 'App\\Models\\CommonApp\\CountryModel',
				'destination' => 'App\\Models\\CommonApp\\DestinationModel',
			]);

		return $models->get($name);
	}

}
