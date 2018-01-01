@extends('admin.protected.dashboard.main')

@section('content')
	<div class="">

		<div class="page-title">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-12">
					<a href="{{ url('dashboard/settings/vendor/lead/create') }}" class="btn btn-success btn-block">Add Vendor</a>
				</div>
				<div class="col-md-4 col-sm-7 col-xs-12 text-center">
					<h3>Lead Vendor List</h3>
				</div>
				<div class="col-md-5 col-sm-8 col-xs-12 form-group pull-right top_search">
					<form action="{{ url('dashboard/settings/vendor/lead') }}" method="head">
						<div class="input-group">
								<input type="text" class="form-control" name="v" placeholder="Search for...">
								<span class="input-group-btn">
									<button class="btn btn-default" type="submit">Go!</button>
								</span>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_content">
						<div class="clearfix"></div>
						<div class="row">
							@forelse($vendors as $key => $vendor)
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="profile_details">
										<div class="well profile_view">
											<div class="col-sm-12">
												<div class="left col-xs-9 nopadding">
													<h4 class="brief"><i>{{ $vendor->company_name }}</i></h4>
													<h2>{{ $vendor->contact_person }}</h2>
													<p>
														<strong>Note: </strong> 
														{{ sub_string($vendor->note) }}
													</p>
												</div>
												<div class="right col-xs-3 text-center nopadding">
													<img src="{{ $vendor->image }}" alt="" class="img-circle img-responsive">
												</div>
												<div class="row">
													<div class="col-xs-12">
														<ul class="list-unstyled">
															<li><i class="fa fa-building"></i> Address: {{ sub_string($vendor->address, 75) }}</li>
															<li><i class="fa fa-phone"></i> {{ $vendor->contact_number }}</li> 
															<li><i class="fa fa-envelope"></i> {{ $vendor->email_id }}</li>
															<li><i class="fa fa-globe"></i> 
																<a class="btn btn-link cursor-pointer" href="{{ $vendor->website }}" target="_blank">
																	{{ sub_string($vendor->website, 15) }}
																</a>
															</li>
														</ul>
													</div>
												</div>
											</div>
											<div class="col-xs-12 bottom text-center">
												<div class="col-md-4 col-sm-4 col-xs-12">
													<a href="{{ url('dashboard/settings/vendor/lead/'.$vendor->id) }}" class="btn btn-primary btn-xs font-size-15">View Profile
													</a>
												</div>
												<div class="col-md-3 col-sm-3 col-xs-12">
													@if ($vendor->status == 'inactive')
														<form method="POST" action="{{url('dashboard/settings/vendor/lead/'.$vendor->id).'/active'}}">
		                          {{ method_field('POST') }}
		                          {{ csrf_field() }}
		                          <input type="submit" class="btn btn-success btn-xs btn-block font-size-15" name="active" value="Active">
		                        </form>
													@endif
												</div>
												<div class="col-md-5 col-sm-5 col-xs-12 m-top-5">
													<b>Status : </b> 
													<span class="{{ statusCss($vendor->is_active) }}">{{ $vendor->status }}</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								@if (($key+1) % 3 == 0 )
									<div class="row"></div>
								@endif
							@empty
								<p>Sorry... there is no vendor</p>
							@endforelse
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<span class="pull-right">
									{{ $vendors->links() }}
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>  
@endsection