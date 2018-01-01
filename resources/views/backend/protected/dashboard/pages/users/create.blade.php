@extends('backend.protected.dashboard.main')

@section('content')
	<div class="row">
		<div class="col-md-8 col-sm-6 col-xs-12 col-md-offset-2">
			<div class="form-style-8 m-top-50">
				<h2 class="font-white">New User Register</h2>
				<form method="POST" action="{{ url('admin/manage/users') }}">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<input type="text" placeholder="First Name" class="{{ $errors->has('firstname') ? 'border-bottom-red' : '' }}" name="firstname" value="{{ old('firstname') }}" required autofocus />
							@if ($errors->has('firstname'))
								<span class="help-block red">
									<strong>{{ $errors->first('firstname') }}</strong>
								</span>
							@endif
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<input type="text" placeholder="Last Name" name="lastname" class="{{ $errors->has('lastname') ? 'border-bottom-red' : '' }}" value="{{ old('lastname') }}" required autofocus />
							@if ($errors->has('lastname'))
								<span class="help-block red">
									<strong>{{ $errors->first('lastname') }}</strong>
								</span>
							@endif
						</div>
					</div>
					<div>
						<input type="text" placeholder="Mobile" name="mobile" class="{{ $errors->has('mobile') ? 'border-bottom-red' : '' }}" value="{{ old('mobile') }}" maxlength="10" required autofocus />
						@if ($errors->has('mobile'))
							<span class="help-block red">
								<strong>{{ $errors->first('mobile') }}</strong>
							</span>
						@endif
					</div>

					<div>
						<input type="text" placeholder="Email" name="email" class="{{ $errors->has('email') ? 'border-bottom-red' : '' }}" value="{{ old('email') }}" required autofocus />
						@if ($errors->has('email'))
							<span class="help-block red">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>

					<div>
						<select name="type" class="{{ $errors->has('type') ? 'border-bottom-red' : '' }}">
							{!! backendTypes(old('type')) !!}
						</select>
						@if ($errors->has('type'))
							<span class="help-block red">
								<strong>{{ $errors->first('type') }}</strong>
							</span>
						@endif
					</div>

					<div>
						<input type="password" placeholder="Password" name="password" class="{{ $errors->has('password') ? 'border-bottom-red' : '' }}" required/>
						@if ($errors->has('password'))
							<span class="help-block red">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>

					<div>
						<input type="password" placeholder="Password Confirmation" name="password_confirmation" class="{{ $errors->has('password_confirmation') ? 'border-bottom-red' : '' }}" required/>
						@if ($errors->has('password_confirmation'))
							<span class="help-block red">
								<strong>{{ $errors->first('password_confirmation') }}</strong>
							</span>
						@endif
					</div>

					<div class="row padding-tb-10">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<button type="submit" class="btn btn-success btn-block">
									Register
							</button>
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