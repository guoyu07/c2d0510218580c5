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
				<form method="POST" action="{{ url('/password/email') }}">
					{{ csrf_field() }}
					<h1>Reset Password</h1>
					<div>
						<input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control {{ $errors->has('email') ? 'border-red' : '' }}" placeholder="E-Mail Address" required autofocus/>
						@if ($errors->has('email'))
							<span class="help-block red">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
					<div class="row">
						<div class="col-md-8 col-md-8 col-xs-12">
							<button type="submit" class="btn btn-default submit pull-left" href="index.html">Send Password Reset Link</button>
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