<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonApp\ImgurController;
use App\Models\CommonApp\ImageModel;
use App\Traits\CallTrait;

ini_set('max_execution_time', 3600);


class ImageController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new ImageModel;
	}

	public function upload(Request $request)
	{
		$image = $request->file;
		$imageName = new_token().'.'.$image->getClientOriginalExtension();
		$image->move(base_path('public/images/tmp'), $imageName);
		$file = public_path('images/tmp/'.$imageName);

		$data = ImgurController::call()->upload($file); // return array

		return json_encode([
						'status' => 'stored successfully', 
						'url' => array_get($data, 'url')
					]);

		// $imagePath = imageUpload($request->file); // no longer use in own server saving to imgur

	}



	/*
	| remove image data from data base
	*/
	public function moveToTrash($id)
	{
		$image = $this->model()->find($id);
		
		if (!is_null($image)) {
			// $path = trashImage($image->path);
			// $image->trash_path = $path;
			$image->is_active = 0;
			$image->save();
		}

		return json_encode(['status' => 200, 'response' => 'deleted successfully.']);

	}


	public function createOrUpdate(Request $request, $id)
	{
		$image = $this->model()->find($id);
		if (is_null($image)) {
			$image = $this->model();
		}

		$image->type = $request->type;
		$image->image_path = $request->image_path;
		$image->caption = $request->caption;
		$image->connectable_id = $request->connectable_id;
		$image->connectable_type = $request->connectable_type;
		$image->save();
		return $image;
	}

	public function destroy($id)
	{
		return $this->model()->where('id', $id)
									->update(['is_active' => 0]);
	}

}
