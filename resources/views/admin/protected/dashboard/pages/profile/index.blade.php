@extends('admin.protected.dashboard.main')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="row">
						@if (!is_null($auth))
							<div class="clearfix"></div>
							<div class="col-md-12 col-sm-12 col-xs-12 profile_details">
								<div class="well col-md-12 col-sm-12 col-xs-12 profile_view">
									<div class="col-md-12 col-sm-12">
										
										<div class="left col-md-9 col-sm-9 col-xs-9 nopadding">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<h4 class="brief"><i>{{ $auth->title }}</i></h4>
											</div>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<h1>{{ $auth->fullname }}</h1>
											</div>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<hr>
											</div>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<p class="padding-tb-10">
													<strong>Address: </strong> 
													{{ $auth->address }}
												</p>
											</div>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<span><i class="fa fa-phone"></i> {{ $auth->mobile }}</span> | <span><i class="fa fa-envelope"></i> {{ $auth->email }}</span>
											</div>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<p class="padding-tb-10">
													<strong>About: </strong> 
													{!! $auth->about !!}
												</p>
											</div>
											<div class="col-md-12 col-sm-12 col-xs-12 m-tb-10px">
												<a href="{{ url('dashboard/profile/password') }}" class="btn-link cursor-pointer">Change password</a>
											</div>
										</div>
										<div class="left col-md-1 col-sm-1 col-xs-1"></div>
		
										<div class="right col-md-2 col-sm-2 col-xs-2 text-center nopadding">
											<img src="{{ $auth->profile_pic }}" alt="" class="img-circle img-responsive">
										</div>
										
									</div>
									<div class="col-xs-12 bottom text-center">
										<div class="col-md-3 col-sm-3 col-xs-12">
											<a href="{{ url('dashboard/profile/edit') }}" class="btn btn-success btn-block"><i class="fa fa-edit"></i> Update Profile</a>
										</div>
									</div>
								</div>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

