@extends('b2b.protected.dashboard.main')

@section('content')
	<div class="row">
		<div class="col-md-8 col-sm-6 col-md-offset-2 col-xs-12">
			<div class="form-style-8" >
				<h2>Detail Plase</h2>
				<form method="POST" action="http://b2b.flygoldfinch.dev/dashboard/tools/contacts/1" accept-charset="UTF-8" enctype="multipart/form-data">
					{{ method_field('PUT') }}
					{{ csrf_field() }}

					<input type="text" name="title" value="{{ $contact->title }}" placeholder="Title" />
					<input type="text" name="fullname" value="{{ $contact->fullname }}" placeholder="Full Name" />
					<input type="text" name="phone" value="{{ $contact->phone }}" placeholder="Mobile" maxlength="10"/>
					<input type="email" name="email" value="{{ $contact->email }}" placeholder="Email" />
					<textarea name="about" onkeyup="adjust_textarea(this)">{{ $contact->about }}</textarea>
					<textarea name="address" onkeyup="adjust_textarea(this)">{{ $contact->address }}</textarea>
					<label for="file">Profile Photo</label>
					<input type="file" class="btn btn-default btn-block" name="profile_pic" />

					<div class="row padding-tb-10">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="col-md-4 col-sm-4 col-xs-12 nopadding">
								<span style="font-size: 25px;">Profile Url</span>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<div class="col-md-3 col-sm-3 col-xs-12">
									<span>
										<a onclick="$('[name=facebook]').toggle();"><i class="fa fa-facebook-square font-size-30"></i></a>
									</span>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-12">
									<span>
										<a onclick="$('[name=googleplus]').toggle();"><i class="fa fa-google-plus font-size-30"></i></a>
									</span>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-12">
									<span>
										<a onclick="$('[name=linkedin]').toggle();"><i class="fa fa-linkedin font-size-30"></i></a>
									</span>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-12">
									<span>
										<a onclick="$('[name=twitter]').toggle();"><i class="fa fa-twitter-square font-size-30"></i></a>
									</span>
								</div>
							</div>
						</div>
					</div>

					<input type="text" name="facebook" value="{{ $contact->facebook }}" placeholder="Facebook Url" value="#" style="display: none;" />
					<input type="text" name="googleplus" value="{{ $contact->googleplus }}" placeholder="Google+ Url" value="#" style="display: none;"/>
					<input type="text" name="linkedin" value="{{ $contact->linkedin }}" placeholder="Linkedin Url" value="#" style="display: none;"/>
					<input type="text" name="twitter" value="{{ $contact->twitter }}" placeholder="Twitter Url" value="#" style="display: none;"/>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<a href="{{ url('dashboard/tools/contacts/'.$contact->id) }}" class="btn btn-primary btn-block radius-0"> Cencel</a>
						</div>	
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="submit" class="btn btn-success btn-block radius-0" value="Save" />
						</div>	
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('js')
	{{-- Custom Js  --}}
	<script src="{{ asset('js/custom-file-input.js') }}"></script>
@endsection