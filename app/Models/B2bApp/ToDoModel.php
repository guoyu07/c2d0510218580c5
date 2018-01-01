<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\B2bApp\UserTodoModel;

class ToDoModel extends Model
{
	protected $table = 'todos';

	public function setStatusAttribute($value)
	{
		$this->attributes['status'] = strtolower($value);
	}


	public function users()
	{
		return $this->belongsToMany('App\User', 'user_todo', 'todo_id', 'user_id');
	}

}
