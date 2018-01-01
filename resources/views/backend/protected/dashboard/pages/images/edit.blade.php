@extends('backend.protected.dashboard.main')

@section('content')
	<div class="row">
		<div class="col-md-8 col-sm-6 col-xs-12 col-md-offset-2">
			<div class="form-style-8 m-top-50">
				<h2 class="font-white">New User Register</h2>
				<form method="POST" action="{{ url('admin/manage/users/'.$user->email) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<input type="text" placeholder="First Name" class="{{ $errors->has('firstname') ? 'border-bottom-red' : '' }}" name="firstname" value="{{ $user->firstname }}" required autofocus />
							@if ($errors->has('firstname'))
								<span class="help-block red">
									<strong>{{ $errors->first('firstname') }}</strong>
								</span>
							@endif
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<input type="text" placeholder="Last Name" name="lastname" class="{{ $errors->has('lastname') ? 'border-bottom-red' : '' }}" value="{{ $user->lastname }}" required autofocus />
							@if ($errors->has('lastname'))
								<span class="help-block red">
									<strong>{{ $errors->first('lastname') }}</strong>
								</span>
							@endif
						</div>
					</div>
					<div>
						<input type="text" placeholder="Mobile" name="mobile" class="{{ $errors->has('mobile') ? 'border-bottom-red' : '' }}" value="{{ $user->mobile }}" maxlength="10" required autofocus />
						@if ($errors->has('mobile'))
							<span class="help-block red">
								<strong>{{ $errors->first('mobile') }}</strong>
							</span>
						@endif
					</div>

					<div>
						<input type="text" placeholder="Email" name="email" class="{{ $errors->has('email') ? 'border-bottom-red' : '' }}" value="{{ $user->email }}" required autofocus />
						@if ($errors->has('email'))
							<span class="help-block red">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
					@if ($user->type != 'su')
						<div>
							<select name="type" class="{{ $errors->has('type') ? 'border-bottom-red' : '' }}">
								<option value="">Error</option>
								{!! backendTypes($user->type) !!}
							</select>
							@if ($errors->has('type'))
								<span class="help-block red">
									<strong>{{ $errors->first('type') }}</strong>
								</span>
							@endif
						</div>
					@endif

					<div class="row padding-tb-10">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<button type="submit" class="btn btn-success btn-block">
								Save
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