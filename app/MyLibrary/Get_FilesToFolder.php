<?php
	
	/*
	|-------------------------------------------------------------------------------------|
	| This function for Getting file form a folder
	|-------------------------------------------------------------------------------------|
	*/

	class Get_FilesToFolder{

		public function Images($dir){
			if (file_exists($dir) == true) {
				$ImagesArray = [];
				$file_display = [ 'jpg', 'jpeg', 'png', 'gif' ];
				
				$dir_contents = scandir($dir);

				if (is_array($dir_contents) && !empty($dir_contents)) {
					foreach ($dir_contents as $file) {
						$file_type = pathinfo($file, PATHINFO_EXTENSION);

						if ($file_type == '' && $file != '.' && $file != '..') {
							$ImagesArray_Temp = $this->Images($dir.$file.'/');
							if (is_array($ImagesArray_Temp) && !empty($ImagesArray_Temp)) {
								foreach ($ImagesArray_Temp as $ImagesArray_Temp_key => $ImagesArray_Temp_value) {
									$ImagesArray[] = $file.'/'.$ImagesArray_Temp_value;
								}
							};
						}
						elseif(in_array($file_type, $file_display) == true) {
							$ImagesArray[] = $file;
						}
					}
				};

				return $ImagesArray;
			} 
			else {
				return false;
			}
		}

		function __construct(){
		}
	}


?>