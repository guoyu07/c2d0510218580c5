<div class="btn-right-bottom cursor-pointer" data-toggle="modal" 
	data-target=".bs-example-modal-to-do">
	<div class="circle-sm bg-red">
		<div class="circle-in text-center"><i class="fa fa-plus font-size-30"></i></div>
	</div>
</div>

<div class="modal fade bs-example-modal-to-do" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel2">To Do Box</h4>
			</div>
			<div class="modal-body">
				<div class="m-bottom-15px">
					<select id="to_do_select" class="select2_multiple form-control" multiple="multiple">
						@foreach ($auth->admin->users as $userValue)
							@if ($auth->id != $userValue->id)
								<option value="{{$userValue->id}}">
									{{ $userValue->firstname }}
								</option>
							@endif
						@endforeach
					</select>
				</div>
				<textarea id="to_do_text" class="resizable_textarea form-control" rows="15"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button"  class="btn btn-default btn-to-do-close" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary btn-to-do">Save changes</button>
			</div>
		</div>
	</div>
</div>
