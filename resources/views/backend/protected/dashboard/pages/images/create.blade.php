@extends('backend.protected.dashboard.main')


@section('css')
	<link rel="stylesheet" href="{{ commonAsset('dashboard/vendors/dropzone/dist/min/dropzone.min.css') }}">
@endsection


@section('content')
	
	{{-- <div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
			<a href="{{ url()->back() }}" class="btn btn-primary btn-block">Back</a>
		</div>
	</div> --}}

	<div class="m-top-10"></div>
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Add Images <strong>({{$title}})</strong></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="form-group">
							<div class="col-md-12 col-sm-12 col-xs-12 m-tb-20px">
								<form id="uploadform" class="uploadform dropzone no-margin nopadding dz-clickable bg-color-gray" data-path="" data-host="">
									{{ csrf_field() }}
									<div class="dz-default dz-message">
										<div class="row">
											<div class="col-md-8 col-sm-8 col-xs-8 col-md-offset-2">
												<div class="height-100px vertical-parent">
													<div class="vertical-child">
														<h1>Drop images here</h1>
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
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div id="save_image" class="btn btn btn-success">Save Image</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/dropzone/dist/min/dropzone.min.js') }}"></script>
@endsection


@section('scripts')
	<script>
		$(document).ready(function(argument) {
			addDropzone('#uploadform');
		});

		$(document).on('click', '#save_image', function () {
			var images = makeImagesObject();
			console.log(images);
			var data = {
					"images" : images,
					'_token' : csrf_token,

				};
			$.ajax({
				url : "{{ $url }}",
				method : "post",
				data : data,
				success : function (data) {
					document.location.href = data;
				}
			});
		});
	</script>

	@include($viewPath.'.partials.dropzone');
@endsection