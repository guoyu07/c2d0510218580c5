<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\CallTrait;

class UrlController extends Controller
{
	use CallTrait;

	public $url = '';
	public $search = '{}';

	public function url($slug = '')
	{
		return str_replace('{}', $slug, $this->url);
	}

	public function __construct(Array $array=[])
	{
		$array = (object)$array;
		if (isset($array->url)) {
			$this->url = $array->url;
		}

		if (isset($array->search)) {
			$this->search = $array->search;
		}
	}

}
