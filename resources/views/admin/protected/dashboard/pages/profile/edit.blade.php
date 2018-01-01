@extends('admin.protected.dashboard.main')

@section('css')
	<link rel="stylesheet" type="text/css" id="u0" href="https://cdn.tinymce.com/4/skins/lightgray/skin.min.css">
	<link href="{{ asset('image_upload/css/style.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="row">
					<div class="col-md-8 col-sm-8 col-xs-12">
						<h2>Profile</h2>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
							<div class="row">
								<div class="col-md-2 col-sm-2 col-xs-2 form-group has-feedback">
									<label for="">Code :</label>
									<input type="text" id="prefix" class="form-control" placeholder="Prefix" value="{{ $auth->prefix }}" required />
								</div>
								<div class="col-md-10 col-sm-10 col-xs-4 form-group has-feedback">
									<label for="">Company Name :</label>
									<input type="text" id="companyname" class="form-control" placeholder="Company Name" value="{{ $auth->companyname }}" required />
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									<label for="">First Name :</label>
									<input type="text" id="firstname" class="form-control" placeholder="First Name" value="{{ $auth->firstname }}" required />
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									<label for="">Last Name :</label>
									<input type="text" id="lastname" class="form-control" placeholder="Last Name" value="{{ $auth->lastname }}" required />
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									<label for="">Contact No. :</label>
									<input type="text" id="mobile" class="form-control" value="{{ $auth->mobile }}" required />
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									<label for="">Email :</label>
									<input type="text" id="email" class="form-control" placeholder="info@example.com" value="{{ $auth->email }}" required />
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="">Profile Image</label>
								 	<form enctype="multipart/form-data" action="{{ url('api/image/upload') }}" method="post" class="w3-form-image">
										<div class="img-area">
											<img id="admin_profile" src="{{ $auth->profile_pic }}" data-host="" data-path="">
											<div class="progressBar">
												<div class="bar"></div>
												<div class="percent">0%</div>
											</div>
											<div class="img-change">
												<span>Change</span>
												<input type="file" accept="image/*" name="file" class="w3-input-image">
											</div>
										</div>
									</form>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="">Logo (if any)</label>
								 	<form enctype="multipart/form-data" action="{{ url('api/image/upload') }}" method="post" class="w3-form-image">
										<div class="img-area">
											<img id="admin_logo" src="{{ $auth->logo }}" data-host="" data-path="">
											<div class="progressBar">
												<div class="bar"></div>
												<div class="percent">0%</div>
											</div>
											<div class="img-change">
												<span>Change</span>
												<input type="file" accept="image/*" name="file" class="w3-input-image">
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
							<label for="">Address :</label>
							<textarea id="address" class="width-100-p" placeholder="Address...">{{ $auth->address }}</textarea>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
							<label for="">Website :</label>
							<textarea id="website" class="width-100-p" placeholder="http://www.example.com">{{ $auth->website }}</textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
							<label for="">About :</label>
							<textarea id="about" placeholder="About company">{{ $auth->about }}</textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="padding-tb-10">
						<div class="col-md-3 col-sm-3 col-xs-12">
							<button class="btn btn-success btn-block btn-save">Save</button>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<a href="{{ url('dashboard/profile') }}" class="btn btn-primary btn-block">Cancel</a>
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
			selector:'#about',
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
			height : 210
		});
	</script>
@endsection

@section('js')
	<script src="{{ asset('image_upload/js/jquery.form.js') }}"></script>
	<script src="{{ asset('image_upload/js/function.js') }}"></script>
@endsection


@section('scripts')
	<script>
		$(document).on('click', '.btn-save', function (argument) {
			$('.x_panel').find('.border-red').removeClass('border-red');

			var dataCheck = { 
					"prefix" :  $('#prefix').val(),
					"companyname" :  $('#companyname').val(),
					"firstname" :  $('#firstname').val(),
					"lastname" :  $('#lastname').val(),
					"mobile" :  $('#mobile').val(),
					"email" :  $('#email').val(),
					"address" :  $('#address').val(),
				},
				
			data = {
					'_token' : csrf_token,
					"profile_host" :  $('#admin_profile').attr('data-host'),
					"profile_path" :  $('#admin_profile').attr('data-path'),
					"logo_host" :  $('#admin_logo').attr('data-host'),
					"logo_path" :  $('#admin_logo').attr('data-path'),
					"website" :  $('#website').val(),
					"about" : tinymce.get('about').getContent()
				},
			
			check = false;

			$.each(dataCheck, function (i, v) {
				if (v == '') { 
					$('#'+i).addClass('border-red');
					check = true;
					return false;
				}
			});

			if (check) {return false;}

			$.extend(data, dataCheck);

			$.ajax({
				url : "{{ url('dashboard/profile/update') }}?format=json",
				type : "post",
				data : data,
				dataType : "JSON",
				success : function () {
					document.location.href = "{{ url('dashboard/profile') }}";
				} 
			});
		});
	</script>
@endsection
