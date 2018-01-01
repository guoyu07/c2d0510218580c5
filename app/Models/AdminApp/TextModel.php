<?php

namespace App\Models\AdminApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommonApp\IndicationModel;

class TextModel extends Model
{
	protected $connection = 'mysql3';
	protected $table = 'texts';
	protected $appends = ['status', 'max_order'];


	public function setOrderAttribute($value)
	{
		if (!is_null($this->order)) {
			if (is_null($value)) {
				$this->attributes['order'] = $this->max_order;
			}
			else{
				$this->attributes['order'] = $value;
			}

		}
	}

	public function setDescriptionAttribute($value = '')
	{
		$this->attributes['description'] = clean_html($value);
	}

	public function getTextAttribute($value)
	{
		$change = strlen($value);
		$value = clean_html($value);
		
		if ($change != strlen($value)) {
			$this->text = $value;
			$this->save();
		}

		return $value;
	}

	public function getStatusAttribute()
	{
		return is_null($this->indication) ? '' : $this->indication->name;
	}


	public function getMaxOrderAttribute()
	{
		$order = $this->select('order')
						->where(["admin_id" => auth()->guard('admin')->user()->id])
							->orderBy("order","desc")
								->first();

		return $order->order;
	}

	public function scopeByAdmin($query)
	{
		$auth = auth()->guard('admin')->user();
		return $query->where('admin_id', $auth->id);
	}

	public function scopeSearchQuery($query, $word)
	{
		return $query->where('title', 'like', '%'.$word.'%')
									->orWhere('text', 'like', '%'.$word.'%');
	}


	public function indication()
	{
		return $this->belongsTo(IndicationModel::class, 'is_active');
	}


}
