<ul class="to_do">
	@foreach ($toDos as $toDoKey => $toDo)
		<li>
			<div class="row">
				<div class="col-md-11 col-sm-11 col-xs-11">
					<label class="{{ $toDo->status == 'Inactive' ? 'line-through' : '' }}">
						<input type="checkbox" class="h-w-17 checkbox_to_do" {{ $toDo->status == 'Inactive' ? 'checked' : '' }} value="{{ $toDo->id }}" data-checked="{{ $toDo->status == 'Inactive' ? '1' : '0' }}"> {{ $toDo->text }}
					</label>
				</div>
				<div class="col-md-1 col-sm-1 col-xs-1">
					<a class="cursor-pointer remove-to-do" data-index="{{ $toDo->id }}"><i class="fa fa-remove font-size-15"></i></a>
				</div>
			</div>
		</li>
	@endforeach
</ul>