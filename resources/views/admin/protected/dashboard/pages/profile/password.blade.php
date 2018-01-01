@extends('b2b.protected.dashboard.main')

@section('content')
	<div class="row">
		<div class="col-md-8 col-sm-6 col-md-offset-2 col-xs-12 m-top-50">
			<div class="form-style-8" >
				<h2>Change Password</h2>
				{!! Form::open(['url' => url('dashboard/profile/password/'), 'method' => 'PUT']) !!}

					<input type="password" name="oldPassword" placeholder="Old password"/>
					<input type="password" name="password" placeholder="New password"/>
					<input type="password" name="password_confirmation" placeholder="Confirm new password"/>

					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="submit" class="btn btn-primary btn-block radius-0" value="Change Password" />
						</div>	
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection