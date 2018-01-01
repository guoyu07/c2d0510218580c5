@extends('backend.protected.dashboard.main')

@section('content')
	<div class="row">
		<div class="col-md-8 col-sm-6 col-xs-12 col-md-offset-2">
			<div class="form-style-8 m-top-50">
				<h2 class="font-white">Reset Password</h2>
				<form method="POST" action="{{ url('admin/manage/users/password/'.$user->email.'/reset') }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					
					<div>
						<input type="text" placeholder="Password" name="email" class="disabled" value="{{$user->email}}" disabled="" />
						@if ($errors->has('password'))
							<span class="help-block red">
								<strong>{{ $errors->first('password') }}</strong>
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
									Reset
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