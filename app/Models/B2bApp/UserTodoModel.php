<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;


class UserTodoModel extends Model
{
	use CallTrait;

	protected $table = 'user_todo';

	public function todo()
	{
		$result = $this->belongsTo('App\Models\B2bApp\ToDoModel', 'todo_id');
		$result->where([['status', '<>', 'deleted']]);
		return $result; 
	}


	public function todoByJoin()
	{
		$auth = auth()->user();
		
		return $this->select('todos.id', 'todos.text', 'todos.status')
									->leftjoin('todos', $this->table.'.todo_id', '=', 'todos.id')
										->where([
													['user_id', '=', $auth->id],
													['status', '<>', 'deleted']
												])
											->get();
	}
}
