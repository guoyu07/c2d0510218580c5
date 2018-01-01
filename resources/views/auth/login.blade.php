@extends('auth.main')
@section('content')
	<div class="login_wrapper">
		<div class="animate form login_form">
		@if (session('success'))
			<div class="alert alert-success">
				{{ session('success') }}
			</div>
		@endif
		@if (session('warning'))
			<div class="alert alert-warning">
				{{ session('warning') }}
			</div>
		@endif
			<section class="login_content">
				<form method="POST" action="{{ url('/login') }}">
					{{ csrf_field() }}
					<h1>Login</h1>
					<div>
						<input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control {{ $errors->has('email') ? 'border-red' : '' }}" placeholder="E-Mail Address" required autofocus/>
						@if ($errors->has('email'))
							<span class="help-block red">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
					<div>
						<input type="password" class="form-control {{ $errors->has('password') ? 'border-red' : '' }}" placeholder="Password" name="password" required/>

						@if ($errors->has('password'))
							<span class="help-block red">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="checkbox pull-left">
								<label>
									<input type="checkbox" name="remember"> Remember Me
								</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-md-4 col-xs-12">
							<button type="submit" class="btn btn-default btn-block submit" href="index.html">Log in</button>
						</div>
						<div class="col-md-8 col-md-8 col-xs-12">
							<a class="reset_pass" href="{{ url('/password/reset') }}">
								Lost your password?
							</a>
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