<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\CallTrait;

class ImagesController extends Controller
{
	use CallTrait;
	
	public function upload(Request $request)
	{
		$imagePath = imageUpload($request->file);
		return ['path' => $imagePath, 'host' => urlimage()];
	}


	public function download($name = '')
	{
		# code...
	}
}
