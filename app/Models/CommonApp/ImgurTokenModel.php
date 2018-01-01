<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;

class ImgurTokenModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'imgur_tokens';

	public function getDataAttribute($value)
	{
		$value = collect(json_decode($value, true));

		if (!$value->has('created_at')) {
			$value = $value->merge([
								"created_at" => $this->created_at->getTimestamp()
							]);
		}

		return $value;
	}

}
