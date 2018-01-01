<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\UserTodoModel;
use App\Models\B2bApp\ToDoModel;
use App\Traits\CallTrait;

class ToDoController extends Controller
{
	use CallTrait;

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$auth = auth()->user();
		
		$toDo = new ToDoModel;
		$toDo->text = $request->toDoText;
		$toDo->status = 'active';
		$toDo->save();
		
		$toDoSelects = [];

		$toDoSelects[] = addDateColumns([
				'user_id' => $auth->id, 
				'todo_id' => $toDo->id,
				'is_assigned' => 0,
			]);

		if (isset($request->toDoSelect)) {
			foreach ($request->toDoSelect as $toDoSelect) {
				$toDoSelects[] = addDateColumns([
						'user_id' => $toDoSelect, 
						'todo_id' => $toDo->id,
						'is_assigned' => 1,
					]);
			}
		}
		
		UserTodoModel::insert($toDoSelects);

		return $toDo; 
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$toDo = ToDoModel::find($id);
		$toDo->status = 'deleted';
		$toDo->save();
	}


	


	public function status(Request $request){
		$toDo = ToDoModel::find($request->id);
		$toDoStatus = $toDo->status;
		if ($toDoStatus == 'active') {
			$toDo->status = 'inactive';
		}
		elseif ($toDoStatus == 'inactive') {
			$toDo->status = 'active';
		}

		$toDo->save();
		return json_encode(['status' => 200, 'response' => 'done']);
	}


	public function all(){
		$todos = UserTodoModel::call()->todoByJoin();
		return $todos;
	}


	public function postAllJson(){
		$todos = $this->all();
		return json_encode($todos);
	}


	public function postAllHtml()
	{
		$toDos = $this->all();
		return view('b2b.protected.dashboard.pages.todo.all', ['toDos' => $toDos]);
	}

	public function remove(Request $request)
	{
		$this->destroy($request->id);
	}

}
