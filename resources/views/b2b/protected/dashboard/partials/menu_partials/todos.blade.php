<li role="presentation" class="dropdown">
	<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
		<i class="fa fa-check-square-o font-size-22 m-top-5"></i>
		<span id="todos_count" class="badge bg-green">{{ $todos->count() ? $todos->count() : ''  }}</span>
	</a>
	
	<ul id="menu_todo" class="width-450 dropdown-menu list-unstyled msg_list" role="menu">
		<li><h2>To-do Lists</h2></li>
		@foreach ($todos as $todo)
			<li>
				<div class="checkbox">
					<label class="nopadding width-100-p">
						<div class="row">
							<div class="col-md-1 col-sm-1 col-xs-1">
								<input id="menu_todo_{{$todo->id}}" type="checkbox" class="flat" data-type="todo" data-id="{{$todo->id}}" {{ $todo->status == 'active' ? '' : 'checked="checked"'}}>
							</div>
							<div class="col-md-9 col-sm-9 col-xs-9 font-size-15">
								<div id="menu_todo_text_{{$todo->id}}" class="row {{ $todo->status == 'active' ? '' : 'line-through'}}">{{ sub_string($todo->text) }}</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-2">
								<a class="btn btn-success btn-xs" href="{{ url('dashboard/todo/'.$todo->id) }}">Open</a>
							</div>
						</div>
					</label>
				</div>
			</li>
		@endforeach
		<li>
			<div class="text-center">
				<a href="{{ url('dashboard/todo') }}">
					<strong>See All Todo</strong>
					<i class="fa fa-angle-right"></i>
				</a>
			</div>
		</li>
	</ul>
</li>