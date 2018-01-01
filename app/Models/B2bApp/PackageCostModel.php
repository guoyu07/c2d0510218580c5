<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class PackageCostModel extends Model
{
	protected $table = 'package_costs';
	protected $appends = ['total_cost'];

	public function getTotalCostAttribute()
	{
		$visa = $this->is_visa ? $this->visa_cost : 0;
		return $this->net_cost+$this->margin+$visa;
	}


	protected static function boot()
  {
    parent::boot();

    static::creating(function($model){
    	$model->token = new_token();
    });
  }

}
