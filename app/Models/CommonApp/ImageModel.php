<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
	protected $table = 'images';
	protected $connection = 'mysql2';
	protected $appends = ['url'];
	protected $guarded = ['id'];
	protected $hidden = [
							'id', 'type', 'status', 'path_or_url', 'image_path', 
							'connectable_id', 'connectable_type','is_active	',
							'created_at', 'updated_at'
					];


	public function getUrlAttribute()
	{
		return $this->validateUrl($this->image_path)
				 ? $this->image_path
				 : urlImage($this->image_path);
	}


	public function validateUrl($url)
	{
		$regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
    $regex .= "(\:[0-9]{2,5})?"; // Port 
    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

		if(preg_match("/^$regex$/i", $url)) // `i` flag for case-insensitive
		{ 
			return true; 
		}else{
			return false;
		} 
	}


	public function connectable()
	{
		return  $this->morphTo();
	}


	/*
	| $data must be like : ['path' => '', 'host' => '']
	*/
	public function makeAndSave(Array $data, $cid, $ctype)
	{
		$array = [];
		foreach ($data as $value) {
			if (isset($value['path'])) {
				$array[] = addDateColumns([
												"type" => 'path',
												"image_path" => $value['path'],
												"connectable_id"	=> $cid,
												"connectable_type"	=> $ctype,
											]);
			}
		}

		return $this->insert($array);
	}

}
