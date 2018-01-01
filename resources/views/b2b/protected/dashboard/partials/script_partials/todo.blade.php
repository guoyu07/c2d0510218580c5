<li>
	<div class="checkbox">
		<label class="nopadding width-100-p">
			<div class="row">
				<div class="col-md-1 col-sm-1 col-xs-1">
					<input id="menu_todo_'+toDoId+'" type="checkbox" class="flat" data-type="todo" data-id="'+toDoId+'" '+isChecked+'>
				</div>
				<div class="col-md-9 col-sm-9 col-xs-9 font-size-15">
					<div id="menu_todo_text_'+toDoId+'" class="row '+lineThrough+'">'+toDoText+'</div>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-2">
					<a class="btn btn-success btn-xs" 
						href="{{ url('dashboard/todo') }}/'+toDoId+'">Open
					</a>
				</div>
			</div>
		</label>
	</div>
</li>