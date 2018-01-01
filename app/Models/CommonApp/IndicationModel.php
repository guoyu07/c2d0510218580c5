<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;

class IndicationModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'indications';

	public function getNameAttribute($name)
	{
		return proper($name);
	}

	public function scopeByKey($query, $key)
	{
		return $this->where('key', $key);
	}

	public function scopeByCategory($query, $category)
	{
		return $this->where('category', '=', $category);
	}


	public function htmlOptions($cat, $isSelected = '', $isKey = true)
	{
		$data = $this->byCategory($cat)->orderBy('order')->get();
	
		$options = '';
		foreach ($data as $value) {
			$key = $isKey ? $value->key : $value->id;
			$selected = $isSelected == $key ? 'selected' : '';
			$options .= '<option value="'.$key.'" '.$selected.'>'
								.$value->name.'</option>';
		}
		return $options;
	}


	public function toKeyValue($cat, Array $with = [], $isKey = true)
	{
		$data = $this->where(['category' => $cat])->get();
		foreach ($data as $value) {
			$key = $isKey ? $value->key : $value->id;
			$with[$key] = $value->name;
		}
		return $with;
	}
	
}
