{{-- {{ dd(request()->search) }} --}}

@extends('admin.protected.dashboard.main')

@section('css')
	<link href="{{ commonAsset('dashboard/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
@endsection

@section('content')
	<div class="row">
		<div class="col-md-4">
			<a href="{{ url('dashboard/inventories/activity/create') }}" class="btn btn-success btn-block">Add Activity</a>
			<div class="m-top-10"></div>
		</div>
	</div>
	@foreach ($countries as $activities)
		<?php $destination = $activities[0]->destination; ?>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel" style="height: auto;">
					<div class="x_title noborder">
						<h2>{{ $destination->country }} <small>(Activities)</small></h2>
						<ul class="nav navbar-right panel_toolbox panel_toolbox1">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content" style="display: none;">
						<table class="table table-hover">
							@foreach ($activities as $activity)
								<tr width="100%">
									<td width="50%">{{ $activity->destination->location }}</td>
									<td width="50%"><a href="{{ url('dashboard/inventories/activity') }}?city={{ $activity->destination_code }}" class="btn btn-success pull-right" target="_blank">Open</a></td>
								</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
		</div>
	@endforeach
	<form action="" id="dest_form" hidden>
		<input type="hidden" name="city" value="">
	</form>


@endsection

@section('js')
	<script type="text/javascript" src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/mydatatable.js') }}"></script>
@endsection


@section('scripts')
	<script>
		$(document).ready(function() {
			var params = {
				'prepend' : 'Destination: <input type="text" data-code="{{ isset($destination->id) ? $destination->id : '' }}" class="form-control location input-sm m-right-10" value="{{ isset($destination->location) ? $destination->location : '' }}">',
				'inputs' : '<input type="hidden" name="city" value="{{ request()->city }}">'

			};
			datatableWithSearch('#datatable', {}, params);
		});


		{{-- for more button --}}
		$(document).on('click', '.user-delete', function () {
			var url = $(this).attr('data-href');
			$.confirm({
				title: 'Are you sure?',
				content: 'If you delete activity you will never be able recover deleted data. <form action="'+url+'" method="post" class="hide">{{ csrf_field() }} {{ method_field('delete') }}<button type="Submit" id="btn_delete"><button></form>',
				buttons: {
					cancel: function () {
						//close
					},
					formSubmit: {
						text: 'Submit',
						btnClass: 'btn-blue',
						action: function () {
							$('#btn_delete').trigger('click');
						}
					}
				}
			});
		});

		$(document).on('click', '.trigger-form', function () {
			$(this).closest('li').find('.input-submit').trigger('click');
		});
		{{-- /for more button --}}


		$(document).on('keyup paste', '.location', function(){
			$(this).autocomplete({
				minLength: 0,
				source: "{{ route("destination.names") }}",
				focus: function( event, ui ) {
					$(this).val( ui.item.name );
					return false;
				},
				select: function( event, ui ) {
					$(this).val( ui.item.name );
					$(this).attr('data-code', ui.item.code);
					$('[name="city"]').val(ui.item.code);
					var serachSorm = $('#dest_form');
					serachSorm.submit();
					return false;
				}
			})
			.autocomplete()
			.data("ui-autocomplete")._renderItem =  function( ul, item ) {
				 return $( "<li>" )
				 .append( "<a>" + item.name+"</a>" )
				 .appendTo( ul );
			 };
		});
	</script>
@endsection