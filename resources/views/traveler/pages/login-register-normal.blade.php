@extends('traveler.layout.main')

@section('content')
	<div class="container">
		<h1 class="page-title">Login/Register on Traveler</h1>
	</div>

	<div class="gap"></div>

	<div class="container">
		<div class="row" data-gutter="60">
			<div class="col-md-4">
				<h3>Welcome to Traveler</h3>
				<p>Ultricies vestibulum egestas ad cras mollis nam dictumst netus leo facilisis justo maecenas molestie ipsum felis mus cubilia hendrerit vestibulum accumsan consectetur convallis vitae nec sapien diam justo lobortis aenean</p>
				<p>Lobortis tristique interdum curae luctus mattis nisl aenean diam suscipit</p>
			</div>
			<div class="col-md-4">
				<h3>Login</h3>
				<form method="POST" action="{{ url('login') }}">
					{{ csrf_field() }}
					<div class="form-group form-group-icon-left"><i class="fa fa-user input-icon input-icon-show"></i>
						<label>Username or email</label>
						<input class="form-control" placeholder="e.g. johndoe@gmail.com" type="text" name="email" value="{{ old('email') }}" />
						@if ($errors->has('email'))
              <span class="help-block font-red">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
	          @endif
					</div>
					<div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon input-icon-show"></i>
						<label>Password</label>
						<input class="form-control" type="password" name="password" placeholder="my secret password" />
						@if ($errors->has('password'))
              <span class="help-block font-red">
                <strong>{{ $errors->first('password') }}</strong>
            	</span>
            @endif
					</div>
					<input class="btn btn-primary" type="submit" value="Sign in" />
				</form>
			</div>
			<div class="col-md-4">
				<h3>New To Traveler?</h3>
				<form method="POST" action="{{ url('register') }}">
					{{ csrf_field() }}
					<div class="form-group form-group-icon-left"><i class="fa fa-user input-icon input-icon-show"></i>
						<label>Full Name</label>
						<input class="form-control" placeholder="e.g. John Doe" type="text" name="fullname" value="{{ old('fullname') }}" />
						@if ($errors->has('fullname'))
              <span class="help-block font-red">
                <strong>{{ $errors->first('fullname') }}</strong>
            	</span>
            @endif
					</div>
					<div class="form-group form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-show"></i>
						<label>Emai</label>
						<input class="form-control" placeholder="e.g. johndoe@gmail.com" type="text" name="email" value="{{ old('email') }}" />
						@if ($errors->has('email'))
              <span class="help-block font-red">
                <strong>{{ $errors->first('email') }}</strong>
            	</span>
            @endif
					</div>
					<div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon input-icon-show"></i>
						<label>Password</label>
						<input class="form-control" type="password" name="password" placeholder="my secret password" />
						@if ($errors->has('password'))
              <span class="help-block font-red">
                <strong>{{ $errors->first('password') }}</strong>
            	</span>
            @endif
					</div>
					<input class="btn btn-primary" type="submit" value="Sign up for Traveler" />
				</form>
			</div>
		</div>
	</div>
@endsection