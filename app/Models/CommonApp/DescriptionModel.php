<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;

class DescriptionModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'descriptions';


	public function relate()
	{
		return $this->morphTo();
	}

}
