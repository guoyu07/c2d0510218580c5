<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;

class VisaDetailModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'visa_details';
	protected $appends = ['visa_forms'];
	protected $casts = ['visa_files' => 'object'];


	public function getVisaFormsAttribute()
	{
		$forms = [];
		foreach ($this->visa_files as $name) {
			$forms[] = [
							"name" => $name,
							"url" => urlImage('visa_files/'.$this->country.'/'.$name)
						];
		}

		return $forms;
	}
}
