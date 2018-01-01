@extends('admin.protected.dashboard.main')

@section('css')
	<link rel="stylesheet" type="text/css" id="u0" href="https://cdn.tinymce.com/4/skins/lightgray/skin.min.css">
	<link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ commonAsset('dashboard/vendors/dropzone/dist/min/dropzone.min.css') }}">
@endsection

@section('content')
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="row">
					<div class="col-md-8 col-sm-8 col-xs-12">
						<h2>Add Activity</h2>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-8 form-group has-feedback">
							<input type="hidden" id="act_id" value="{{ $activity->id }}">

							<input type="text" id="title" class="form-control" placeholder="Title" value="{{ $activity->title }}" required />
						</div>
						<div class="col-md-4 col-sm-4 col-xs-4 form-group has-feedback">
							<input type="text" id="destination" data-code="{{ isset($destination->id) ? $destination->id : '' }}" class="form-control destination" placeholder="Destination" value="{{ isset($destination->location) ? $destination->location : '' }}" required />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-8 form-group has-feedback">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
									<h2 class="m-top-15">Description :</h2>
									<textarea id="description" class="form-control" placeholder="Description" style="height: 268px;">{{ $activity->description }}</textarea>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="x_panel" style="height: auto;">
										<div class="x_title noborder">
											<h2>Inclusion (optional)</h2>
											<ul class="nav navbar-right panel_toolbox panel_toolbox1">
												<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
											</ul>
										</div>
										<div class="x_content" style="display: none;">
											<textarea id="inclusion" class="tinymce" placeholder="text">{{ $activity->inclusion }}</textarea>
										</div>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="x_panel" style="height: auto;">
										<div class="x_title noborder">
											<h2>Exclusion (optional)</h2>
											<ul class="nav navbar-right panel_toolbox panel_toolbox1">
												<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
											</ul>
										</div>
										<div class="x_content" style="display: none;">
											<textarea id="exclusion" class="tinymce" placeholder="text">{{ $activity->exclusion }}</textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-4">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
									<input type="text" id="pick_up" class="form-control" data-inputmask="'mask': '99:99'" placeholder="Pick-Up Time in HH:MM (optaional)" value="{{ $activity->pick_up }}" required />
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
									<input type="text" id="duration" class="form-control" data-inputmask="'mask': '99:99'" placeholder="Duration in HH:MM (optaional)" value="{{ $activity->duration }}" required />
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
									<form id="uploadform" class="uploadform dropzone no-margin nopadding dz-clickable text-left min-max-height-355px bg-color-gray" data-path="" data-host="">	
										{{ csrf_field() }}
										<div class="dz-default dz-message">
											<div class="row">
												<div class="col-md-8 col-sm-8 col-xs-8 col-md-offset-2">
													<div class="height-100px vertical-parent">
														<div class="vertical-child">
															Drop activity image here
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="padding-tb-10">
						<div class="col-md-3 col-sm-3 col-xs-12">
							<button class="btn btn-success btn-block btn-save">Save</button>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<a href="{{ url('dashboard/inventories/activity') }}?{{ $query }}" class="btn btn-primary btn-block">Cancel</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('headJs')
	<script src="{{ asset('js/tinymce.min.js') }}"></script>
	<script>
		tinymce.init({ 
			selector:'textarea.tinymce',
			plugins : 'autolink link image lists preview table',
			menu: {
				file: {title: 'File', items: 'newdocument'},
				edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
				insert: {title: 'Insert', items: 'link media | template hr'},
				view: {title: 'View', items: 'visualaid'},
				format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
				table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
				tools: {title: 'Tools', items: 'spellchecker code'}
			},
			menubar: 'file edit insert view format table tools',
			height : 172
		});
	</script>
@endsection

@section('js')
	<script type="text/javascript" src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/dropzone/dist/min/dropzone.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
	<script src="{{ asset('js/mydropzone.js') }}"></script>
@endsection


@section('scripts')
	<script>
		$(document).ready(function(argument) {
			addDropzone('#uploadform', '{{ url('api/image/upload') }}');
      $(":input").inputmask();
		});

		$(document).on('keyup paste', '.destination', function(){
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

		$(document).on('click', '.btn-save', function (argument) {
			var id = $('#act_id').val();
			var title = $('#title').val();
			var pick_up = $('#pick_up').val();
			var duration = $('#duration').val();
			$('.x_panel').find('.border-red').removeClass('border-red');
			
			if (title == '') { 
				$('#title').addClass('border-red');
				return false;
			}

			var destCode = $('#destination').attr('data-code');
			if (destCode == '') {
				$('#destination').addClass('border-red');
				$.alert({
					'title' : 'Alert ?',
					'content' : 'select destination first'
				});
				return false;
			}

			var images = makeImagesObject();
			var desc = $('#description').val();
			var inclusion = tinymce.get('inclusion').getContent();
			var exclusion = tinymce.get('exclusion').getContent();
			var data = {
					'id' : id,
					'title'	: title,
					'format' : 'json',
					'images' : images,
					'pick_up' : pick_up,
					'description'	: desc,
					'_token' : csrf_token,
					'duration' : duration,
					'dest_code'	: destCode,
					'inclusion' : inclusion,
					'exclusion' : exclusion
				};

			console.log(data);

			$.ajax({
				url : "{{ url('dashboard/inventories/activity/store') }}",
				type : "post",
				data : data,
				dataType : "JSON",
				success : function () {
					document.location.href = "{{ url('dashboard/inventories/activity') }}?city="+destCode;
				} 
			});
		});
	</script>
@endsection
