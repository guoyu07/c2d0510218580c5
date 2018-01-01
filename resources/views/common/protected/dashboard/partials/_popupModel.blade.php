{{-- Popup modal --}}
<div class="popup-model" hidden>
	<div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-4 col-sm-offset-4 m-top-100">
		<div class="x_panel radius-6">
			<div class="row">
				<div class="col-md-11 col-sm-11 col-xs-11">
					<h4 id="popup_title"  class="modal-title" >Title</h4>
				</div>
				<div class="col-md-1 col-sm-1 col-xs-1">
					<i class="fa fa-remove pull-right font-size-17 cursor-pointer" onclick="hidePopUp()"></i>
				</div>
			</div>
			<hr class="border-top-gray">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div id="popup_body" class="popup-container"></div>
				</div>
			</div>

		</div>
	</div>
</div>
{{-- /Popup modals --}}
{{-- Small modal --}}
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel2">To Do Box</h4>
			</div>
			<div class="modal-body" id="myModalBody2">
				<textarea class="resizable_textarea form-control" 
					placeholder="What you want to do, just share me your thought and I'll let you know."
					style="height: 300px;"></textarea>
			</div>
			<div class="modal-footer" id="myModalButton2">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>

		</div>
	</div>
</div>
{{-- /Small modals --}}

{{-- Large Modal --}}
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Modal title</h4>
			</div>
			<div class="modal-body" id="myModalBody">
				<h4>Text in a modal</h4>
				<p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
				<p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
			</div>
			<div class="modal-footer" id="myModalButton">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>

		</div>
	</div>
</div>
{{-- /Large Modal --}}


{{-- warning modal --}}
<div class="modal fade bs-example-modal-warning" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<h3 class="modal-title" id="myModalLabel3"><i class="fa fa-warning" ></i> Warning</h3>
			</div>
			<div class="modal-body" id="myModalBody3">
				<h4>Are you sure you want to delete?</h4>
			</div>
			<div class="modal-footer" id="myModalButton3">
				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
			</div>
		</div>
	</div>
</div>
{{-- /warning model --}}