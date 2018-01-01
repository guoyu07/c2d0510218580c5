@extends('admin.protected.dashboard.main')

@section('content')
	<div class="">

		<div class="page-title">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-12">
					<a href="{{ url('dashboard/enquiry') }}" class="btn btn-success btn-block"><i class="fa fa-arrow-left"></i> Back to All Enquiry</a>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_content">
						<div class="row">
							<div class="clearfix"></div>
							<div class="col-md-12 col-sm-12 col-xs-12 profile_details">
								<div class="well col-md-12 col-sm-12 col-xs-12 profile_view">
									<div class="col-md-12 col-sm-12">
										<div class="row">
											<div class="col-md-8 col-sm-8 col-xs-12">
												<h1>{{ $enquiry->fullname }}</h1>
												
											</div>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<h4 class="m-top-20 text-right"><b>Assign To :</b> 
													{{ $enquiry->user->firstname.' '. $enquiry->user->lastname." (".$enquiry->user->email.")" }}</h4>
											</div>
										</div>
										<hr>
										<div class="col-md-12 col-sm-12 col-xs-12">
											<p><b>Status : </b>(<span class="{{ statusCss($enquiry->status) }}">{{ $enquiry->status }}</span>)</p>
										</div>
										<div class="col-md-12 col-sm-12 col-xs-12">
											<p><b>Enquiry From : </b> {{ $enquiry->leadVendor->company_name }}</p>
										</div>
										<div class="col-md-12 col-sm-12 col-xs-12">
											<p><i class="fa fa-phone"></i> {{ $enquiry->mobile }}</p>
										</div>
										<div class="col-md-12 col-sm-12 col-xs-12">
											<p><i class="fa fa-envelope"></i> {{ $enquiry->email }}</p>
										</div>
										<div class="col-md-12 col-sm-12 col-xs-12">
											<p class="padding-tb-10"><strong>Note: </strong> {{ $enquiry->note }}</p>
										</div>
									</div>
									<div class="col-xs-12 bottom text-center">
										<div class="col-md-3 col-sm-3 col-xs-12">
											<a href="{{ url('dashboard/enquiry/'.$enquiry->id.'/edit') }}" class="btn btn-success btn-block"><i class="fa fa-edit"></i> Update Info</a>
										</div>
										<div class="col-md-3 col-sm-3 col-xs-12">
											<a data-toggle="modal" data-target=".bs-example-modal-warning" class="btn btn-primary btn-block"><i class="fa fa-trash"></i> Action</a>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-12"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade bs-example-modal-warning" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<h3 class="modal-title" id="myModalLabel2"><i class="fa fa-edit" ></i> Action</h3>
				</div>
				<div class="modal-body">
					<h4>What <b>Action</b> you want to take?</h4>
				</div>
				<div class="modal-footer">
					<div class="row">
						@if ($enquiry->status != 'active')
							<div id="active_button" class="col-md-6 col-sm-6 col-xs-6">
								<form id="active_form" method="POST" action="{{url('dashboard/enquiry/'.$enquiry->id.'/active')}}">
									{{ csrf_field() }}
									<input type="submit" class="btn btn-success btn-block" name="active" value="Active">
								</form>
							</div>
						@endif

						<form id="delete_form" method="POST" action="{{url('dashboard/enquiry/'.$enquiry->id)}}">
							{{ method_field('DELETE') }}
							{{ csrf_field() }}
							@if ($enquiry->status != 'inactive')
								<div id="inactive_button" class="col-md-6 col-sm-6 col-xs-6">
									<input type="submit" class="btn btn-warning btn-block" name="inactive" value="Inactive">
								</div>
							@endif
							<div class="col-md-6 col-sm-6 col-xs-6">
								<input type="submit" class="btn btn-danger btn-block" name="delete" value="Delete">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection