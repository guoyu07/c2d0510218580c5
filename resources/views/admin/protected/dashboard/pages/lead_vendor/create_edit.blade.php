@extends('admin.protected.dashboard.main')

@section('css')
	<link href="{{ asset('image_upload/css/style.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="row">
					<div class="col-md-8 col-sm-8 col-xs-12">
						<h2>Lead Vendor</h2>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="form-group">
						<div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-4 form-group has-feedback">
									<label for="">Company Name :</label>
									<input type="text" id="companyname" class="form-control" placeholder="Company Name" value="{{ isset($vendor) ? $vendor->company_name : old('company_name') }}" required />
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									<label for="">Contact Person :</label>
									<input type="text" id="person" class="form-control" placeholder="John Doe" value="{{ isset($vendor) ? $vendor->contact_person : old('contact_person') }}" required />
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									<label for="">Contact No. :</label>
									<input type="text" id="mobile" class="form-control" value="{{ isset($vendor) ? $vendor->contact_number : old('contact_number') }}" required />
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									<label for="">Email :</label>
									<input type="text" id="email" class="form-control" placeholder="info@example.com" value="{{ isset($vendor) ? $vendor->email_id : old('email_id') }}" required />
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									<label for="">Address :</label>
									<textarea id="address" class="width-100-p" placeholder="Address...">{{ isset($vendor) ? $vendor->address : old('address') }}</textarea>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									<label for="">Website :</label>
									<textarea id="website" class="width-100-p" placeholder="http://www.example.com">{{ isset($vendor) ? $vendor->website : old('website') }}</textarea>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
							<label for="">Logo (if any)</label>
						 	<form enctype="multipart/form-data" action="{{ url('api/image/upload') }}" method="post" class="w3-form-image">
								<div class="img-area">
									<img id="vendor_logo" src="{{ isset($vendor) ? $vendor->image : urlImage(old('image_path')) }}" data-host="" data-path="{{ old('image_path') }}">
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
					
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
							<label for="">Note :</label>
							<textarea class="width-100-p" id="vendor_note" placeholder="About company">{{ isset($vendor) ? $vendor->note  : old('note') }}</textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="padding-tb-10">
						<div class="col-md-3 col-sm-3 col-xs-12">
							<button class="btn btn-success btn-block btn-save">Save</button>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<a href="{{ url('dashboard/settings/vendor/lead') }}" class="btn btn-primary btn-block">Cancel</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<form action="{{ url('dashboard/settings/vendor/lead/'.(isset($vendor->id) ? $vendor->id : '')) }}" method="post" id="main_form" hidden="">
			{{ csrf_field() }}
			{{ isset($vendor->id) ? method_field('put') : "" }}
			<input type="hidden" name="company_name" value="">
			<input type="hidden" name="contact_person" value="">
			<input type="hidden" name="contact_number" value="">
			<input type="hidden" name="email_id" value="">
			<input type="hidden" name="address" value="">
			<input type="hidden" name="website" value="">
			<input type="hidden" name="note" value="">
			<input type="hidden" name="image_path" value="">
			<input type="submit" id="form_submit">
		</form>
	</div>
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
					"companyname" :  $('#companyname').val(),
					"person" :  $('#person').val(),
					"mobile" :  $('#mobile').val(),
					"email" :  $('#email').val(),
					"address" :  $('#address').val(),
				},
				
			data = {
					"note" : $('#vendor_note').val(),
					"website" :  $('#website').val(),
					"image_host" :  $('#vendor_logo').attr('data-host'),
					"image_path" :  $('#vendor_logo').attr('data-path')
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

			$('[name="company_name"]').val(data.companyname);
			$('[name="contact_person"]').val(data.person);
			$('[name="contact_number"]').val(data.mobile);
			$('[name="email_id"]').val(data.email);
			$('[name="address"]').val(data.address);
			$('[name="website"]').val(data.website);
			$('[name="note"]').val(data.note);
			$('[name="image_path"]').val(data.image_path);

			var form = $('#main_form');
			$(form).submit();
		});
	</script>
@endsection
