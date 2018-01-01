<?php

namespace App\Models\BackendApp;

use Illuminate\Database\Eloquent\Model;


/*
| if want to change or edit any plan then create new 
| because this can cause an error or break the db relation
| or transaction can be wrong mean amount calulation  
*/

class PlanModel extends Model
{
	protected $connection = 'mysql1';
	protected $table = 'plans';
	protected $appends = ['total'];


	public function getTotalAttribute()
	{
		return $this->price+$this->tax;
	}

}
