<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackendApp\ViatorActivityModel;
ini_set('max_execution_time', 7200);


class ViatorActivitiesController extends Controller
{
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
			//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
			//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
			//
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
	public function destroy($id)
	{
			//
	}


	public function rank($id, Request $request)
	{
		ViatorActivityModel::where(['id' => $id])->update(['rank' => $request->index]);
	}

	public function insertActivities()
	{
		$files = $this->list_folder_files(public_path('viator/product'));
		$result = [];
		$query = '';
		$found = false;

		for ($i=151; $i <= 175; $i++) { 
			$data = file_get_contents($files[$i]);
			$data = json_decode($data, true);
			$insertArray = $data['data'];
			
			foreach ($insertArray as $keys => &$values) {
				foreach ($values as $key => &$value) {
					if ($key == 'catIds' || $key == 'subCatIds') {
						$value = json_encode($value);
					}
					$value = addslashes($value);
				}

				$values['created_at'] = date('Y-m-d H:i:s');
				$values['updated_at'] = date('Y-m-d H:i:s');

				$arr_key = array_keys($values);

				$query .= 'INSERT INTO `viator_activities`(`'.implode('`, `', $arr_key).'`) 

				VALUES ';
				$query .= '(\''.implode("', '" , $values).'\')';
				$query .= ';


				';
			}
		}

		dd_pre_echo($query);


		ViatorActivityModel::insert($result);
		dd($result);

	}


	public function list_folder_files($dir){
		$ffs = scandir($dir);
		$result = [];
		foreach($ffs as $ff){
			if($ff != '.' && $ff != '..'){
				if(is_dir($dir.'/'.$ff)){
					$resultTemp = $this->list_folder_files($dir.'/'.$ff);
					$result = array_merge($resultTemp, $result);

				}else{
					$result[] = $dir.'/'.$ff;
				}
			}
		}
		return $result;
	}


}

