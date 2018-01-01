@extends('auth.main')
@section('content')
	<div class="login_wrapper">
		<div class="animate form login_form">
			@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
			@endif
			<section class="login_content">
				<form method="POST" action="{{ url('/password/reset') }}">
					{{ csrf_field() }}
					<h1>Reset Password</h1>
          <input type="hidden" name="token" value="{{ $token }}">
					<div>
						<input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control {{ $errors->has('email') ? 'border-red' : '' }}" placeholder="E-Mail Address" required autofocus/>
						@if ($errors->has('email'))
							<span class="help-block red">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
					<div>
						<input id="password" type="password" class="form-control {{ $errors->has('password_confirmation') ? 'border-red' : '' }}" name="password" placeholder="Password" required/>
						@if ($errors->has('password'))
							<span class="help-block red">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>
					<div>
						<input id="password-confirm" type="password" name="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'border-red' : '' }}" placeholder="Confirm Password" required/>
						@if ($errors->has('email'))
							<span class="help-block red">
								<strong>{{ $errors->first('password_confirmation') }}</strong>
							</span>
						@endif
					</div>
					<div class="row">
						<div class="col-md-8 col-md-8 col-xs-12">
							<button type="submit" class="btn btn-default submit pull-left" href="index.html">Reset Password</button>
						</div>
					</div>

					<div class="clearfix"></div>

					<div class="separator">
						<div class="clearfix"></div>
						<br />

						<div>
              @include('auth.partials._footer')
						</div>
					</div>
				</form>
			</section>
		</div>
	</div>
@endsection