<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowDuplicate extends Controller
{

	public function show($dir = ''){

		$result = $this->list_folder_files('D:/OneDrive/FgfDrive');

		echo 'All File';
		pre_echo(json_encode($result));


		echo '<br/><br/><br/>Duplicate';
		$result = $this->findDuplicate($result);
		pre_echo(json_encode($result));

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

	public function findDuplicate($dirArray = [])
	{	
		$result = [];
		foreach ($dirArray as $value) {
			if (findWord(' (', $value) && findWord(')', $value)) {
				if (preg_match("/\d/", $value) > 0) {
					$result[] = $value;
				}
			}
		}

		return $result;
	}

	public function delete($value='')
	{
		$string = '';

		$delete = json_decode($string);
		if (is_array($delete)) {
			foreach ($delete as $dkey => $dvalue) {
				unlink($dvalue);
			}
		}

	}

}
